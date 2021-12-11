import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, NgForm, ValidationErrors, ValidatorFn, Validators } from '@angular/forms';

import { Servico } from 'src/app/models/servico';
import { Consultor } from 'src/app/models/consultor';
import { Agendamento } from 'src/app/models/agendamento';
import { AgendamentoFormData } from './agendamento-form-data';
import { AgendamentoComponenteData } from './agendamento-componente-data';
import { AgendamentoService } from 'src/app/services/agendamento.service';
import { DialogComponent, DialogData } from '../dialog/dialog.component';
import { MatDialog } from '@angular/material/dialog';
import { ApiError } from 'src/app/services/api-error';
import { ConsultorRuleService } from 'src/app/services/consultor-rule.service';

@Component({
  selector: 'app-agendamento-cadastro',
  templateUrl: './agendamento-cadastro.component.html',
  styleUrls: ['./agendamento-cadastro.component.scss']
})
export class AgendamentoCadastroComponent implements OnInit {

  minDate: Date;
  calendario: Date[] = [];

  cadastro = new FormGroup({
    consultor: new FormControl(0, [Validators.required, Validators.min(1)]),
    servico: new FormControl(0, [Validators.required, Validators.min(1)]),
    data: new FormControl('', [Validators.required]),
    email_cliente: new FormControl('', [Validators.required, Validators.email]),
  });

  private _dataComponent: AgendamentoComponenteData = {
    servicos: [],
    consultores: []
  };
  public filterData = this.filterDateDefault;

  @Input()
  set agendamento(data: AgendamentoComponenteData) {
    this._dataComponent = data;
  }

  get servicos(): Servico[] {
    return this._dataComponent.servicos;
  }

  get consultores(): Consultor[] {
    return this._dataComponent.consultores;
  }

  constructor(
    private agendamentoService: AgendamentoService,
    public dialog: MatDialog,
    private consultorService:ConsultorRuleService
  ) {
    const currentDate = new Date();
    let _minDate = new Date();
    _minDate.setDate(currentDate.getDate() + 1);
    this.minDate = _minDate;
    this.calendarioUpdate();
  }

  ngOnInit(): void {
    this.onChanges();
  }

  resetForm(): void {
    this.filterData = this.filterDateDefault;
    this._dataComponent = this.consultorService.resetData(this._dataComponent);
    this.cadastro.reset();
  }

  private filterDateDefault(d: Date | null): boolean {
    const date = (d || new Date());
    const day = date.getDay();
    return day !== 0 && day !== 6;
  }

  openDialog(data: DialogData): void {
    const dialogRef = this.dialog.open(DialogComponent, {
      width: '50%',
      data,
      disableClose: true,
    });
  }

  cadastrar(agendamento: Agendamento): void {
    this.agendamentoService.postAgendamento(agendamento).subscribe(() => {
      this.openDialog(
        {
          title: 'Agendamento',
          message: 'Agendamento Realizado com sucesso.'
        }
      );
    },
      (apiError: ApiError) => {
        this.openDialog(
          {
            title: 'Erro',
            message: apiError.error.errors.message
          }
        );
      });
  }

  calendarioUpdate() {
    const consultorForm = this.cadastro.get('consultor');
    
    consultorForm?.valueChanges.subscribe((consultorId) => {
      if(consultorForm?.valid){
        this.getAgendamento({ consultorId });
      }
    });
  }

  getAgendamento(info: { consultorId: number }) {
    this.agendamentoService.listAgendamento({ consultorId: info.consultorId }).subscribe((agendamento: Agendamento[]) => {
      let datasAgenda = agendamento.map((agenda: Agendamento) => {
        return new Date(agenda.data);
      });
      this.filterData = (d: Date | null): boolean => {
        const date = (d || new Date());
        let dataOcupada = datasAgenda.find((dataAgenda) => {
          return date.valueOf() === dataAgenda.valueOf();
        })
        return this.filterDateDefault(d) && dataOcupada === undefined;
      };
    });
  }

  onChanges(): void {
    this.cadastro.valueChanges.subscribe((agendamento: AgendamentoFormData) => {
      this._dataComponent = this.consultorService.controladorFormulario(agendamento, this._dataComponent);
    })
  }

  onSubmit(): void {
    const data = this.cadastro.value;

    if (this.cadastro.valid) {
      const date = new Date(data.data).toISOString();
      let agendamento: Agendamento = {
        consultor: this.consultores[data.consultor],
        data: date,
        email_cliente: data.email_cliente,
        servico: this.servicos[data.servico],
      };
      this.cadastrar(agendamento);
    }
    this.resetForm();
  }
}
