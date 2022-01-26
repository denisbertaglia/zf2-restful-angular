import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';

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
import { ServicoService } from 'src/app/services/servico.service';
import { ConsultorService } from 'src/app/services/consultor.service';
import { Feriado } from 'src/app/models/feriado';
import { FeriadosNacionaisService } from 'src/app/services/feriados-nacionais.service';
import { MatDatepickerInputEvent } from '@angular/material/datepicker';
import { concat } from 'rxjs';

@Component({
  selector: 'app-agendamento-cadastro',
  templateUrl: './agendamento-cadastro.component.html',
  styleUrls: ['./agendamento-cadastro.component.scss'],
  providers: [ConsultorRuleService],
})
export class AgendamentoCadastroComponent implements OnInit {

  minDate: Date;
  calendario: Date[] = [];
  cadastroDefaultValues ={
    consultor: 0,
    servico: 0,
    data: '',
    email_cliente: '',
  };
  cadastro = new FormGroup({
    consultor: new FormControl(this.cadastroDefaultValues.consultor, [Validators.required, Validators.min(1)]),
    servico: new FormControl(this.cadastroDefaultValues.servico, [Validators.required, Validators.min(1)]),
    data: new FormControl({ value: this.cadastroDefaultValues.data, disabled: true }, [Validators.required],),
    email_cliente: new FormControl(this.cadastroDefaultValues.email_cliente, [Validators.required, Validators.email]),
  });

  feriados: Feriado[] = [];

  private dataComponent: AgendamentoComponenteData = {
    servicos: [],
    consultores: []
  };

  public filterData = this.filterDateDefault;

  get servicos(): Servico[] {
    return this.dataComponent.servicos;
  }

  get consultores(): Consultor[] {
    return this.dataComponent.consultores;
  }

  constructor(
    private agendamentoService: AgendamentoService,
    public dialog: MatDialog,
    private consultorRuleService: ConsultorRuleService,
    private servicoService: ServicoService,
    private consultorService: ConsultorService,
    private feriadosService: FeriadosNacionaisService
  ) {

    const currentDate = new Date();
    let _minDate = new Date();
    _minDate.setDate(currentDate.getDate() + 1);
    this.minDate = _minDate;
    this.calendarioUpdate();

  }

  ngOnInit(): void {
    this.onChanges();
    this.getConsultores();
    this.getServico();
    this.getFeriados();
  }

  resetForm(): void {
    this.filterData = this.filterDateDefault;
    this.cadastro.setValue(this.cadastroDefaultValues);
  }

  filterDateDefault(d: Date | null): boolean {
    const date = (d || new Date());
    const day = date.getDay();
    return (day !== 0 && day !== 6);
  }

  filtroferiado(d: Date | null): boolean {
    const date = (d || new Date());
    let isDataFeriado = this.feriados.find((feriado) => {
      let result = date.valueOf() === new Date(feriado.date).setHours(0).valueOf();
      return result;
    })
    return isDataFeriado === undefined;
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
      if (consultorForm?.valid) {
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
        return this.filtroferiado(d) && this.filterDateDefault(d) && dataOcupada === undefined;
      };
    });
  }
  getServico() {
    this.servicoService.getServico().subscribe((servico: Servico[]) => {
      this.dataComponent.servicos = servico;
    });
  }

  getConsultores() {
    this.consultorService.getConsultores().subscribe((consultor: Consultor[]) => {
      this.dataComponent.consultores = consultor;
    });
  }

  getFeriados() {
    const anoAtual = new Date().getFullYear();
    const anosProximos = 2;
    const proximosAnos = [...Array(anosProximos + 1).keys()].map(acrescimo => anoAtual + acrescimo);
    this.feriadosService.feriadosMultiplosAnos(proximosAnos).subscribe((feriados: Feriado[]) => {
      this.feriados.push(...feriados);
    });

    this.filterData = (d: Date | null): boolean => {
      const date = (d || new Date());
      return this.filtroferiado(d) && this.filterDateDefault(d);
    };
    this.cadastro.controls['data'].enable();
  }

  bloquearFeriados() {
    this.filterData = (d: Date | null): boolean => {
      const date = (d || new Date());
      return this.filtroferiado(d) && this.filterDateDefault(d);
    };
    this.cadastro.controls['data'].enable();
  }

  onChanges(): void {
    this.cadastro.valueChanges.subscribe((agendamento: AgendamentoFormData) => {
      this.dataComponent = this.consultorRuleService.controladorFormulario(agendamento, this.dataComponent);
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
