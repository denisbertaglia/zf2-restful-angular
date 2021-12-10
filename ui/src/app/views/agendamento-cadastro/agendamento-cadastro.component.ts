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
    fb: FormBuilder,
    private agendamentoService: AgendamentoService,
    public dialog: MatDialog,
  ) {
    this._dataComponent = {
      servicos: [],
      consultores: []
    };
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
    this.cadastro.get('consultor')?.valueChanges.subscribe((consultorId) => {
      this.getAgendamento({ info: consultorId });
    });
  }

  getAgendamento(teste: { info: number }) {
    this.agendamentoService.listAgendamento({ consultorId: teste.info }).subscribe((agendamento: Agendamento[]) => {
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

  controladorFormulario(agenda: AgendamentoFormData, data: AgendamentoComponenteData): AgendamentoComponenteData {
    const servicoId = agenda.servico;
    const consultorId = agenda.consultor;
    const consultor = this.consultores[consultorId];

    if (consultorId !== 0) {
      consultor.servicos?.map((consultorServico) => {
        data.servicos = this.servicos?.map((servico) => {
          if (consultorServico.id !== servico.id && servico.id !== 0) {
            servico.disabled = true;
          } else {
            servico.disabled = false;
          }
          return servico;
        });
      });
    } else {
      data.servicos = this.servicos.map((servico) => {
        servico.disabled = false;
        return servico;
      });
    }

    if (servicoId !== 0) {
      data.consultores = this.consultores.map((consul) => {
        consul.servicos?.map((servicoConsultor) => {
          if (servicoConsultor.id !== servicoId && servicoConsultor.id !== 0) {
            consul.disabled = true;
          } else {
            consul.disabled = false;
          }
        });
        return consul;
      });
    } else {
      data.consultores = data.consultores.map((consul) => {
        consul.servicos?.map((servicoConsultor) => {
          consul.disabled = false;
        });
        return consul;
      });
    }

    if (consultorId === 0 && servicoId === 0) {
      data.consultores = data.consultores.map((consultor) => {
        consultor.disabled = false;
        return consultor;
      });
      data.servicos = data.servicos.map((servico) => {
        servico.disabled = false;
        return servico;
      });
    }
    return data;
  }

  onChanges(): void {
    this.cadastro.valueChanges.subscribe((agendamento: AgendamentoFormData) => {
      this._dataComponent = this.controladorFormulario(agendamento, this._dataComponent);
    })
  }

  onSubmit(): void {
    const data = this.cadastro.value;

    //if (this.cadastro.valid) {
    const date = new Date(data.data).toISOString();
    let agendamento: Agendamento = {
      consultor: this.consultores[data.consultor],
      data: date,
      email_cliente: data.email_cliente,
      servico: this.servicos[data.servico],
    };

    //this.cadastrar(agendamento);
    console.log("----------*------------");
    console.log(agendamento);
    console.log("----------*------------");
    //}
    this.resetForm();
  }
}
