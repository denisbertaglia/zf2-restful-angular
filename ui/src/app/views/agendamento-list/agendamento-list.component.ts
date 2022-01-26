import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

import { Servico } from 'src/app/models/servico';
import { Consultor } from 'src/app/models/consultor';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { AgendamentoComponenteData } from '../agendamento-cadastro/agendamento-componente-data';
import { ConsultorRuleService } from 'src/app/services/consultor-rule.service';
import { AgendamentoFormData } from '../agendamento-cadastro/agendamento-form-data';

import { AgendamentoParamsFilter } from 'src/app/services/agendamento-params-filter';
import { Agendamento } from 'src/app/models/agendamento';
import { ServicoService } from 'src/app/services/servico.service';
import { ConsultorService } from 'src/app/services/consultor.service';
import { FeriadosNacionaisService } from 'src/app/services/feriados-nacionais.service';
import { Feriado } from 'src/app/models/feriado';


@Component({
  selector: 'app-agendamento-list',
  templateUrl: './agendamento-list.component.html',
  styleUrls: ['./agendamento-list.component.scss'],
  providers: [ConsultorRuleService],
})
export class AgendamentoListComponent implements OnInit {

  @Input()
  agendamentos: Agendamento[] = [];
  displayedColumns: string[] = ['consultor.nome', 'data', 'servico.descricao', 'email_cliente',];

  filtro = new FormGroup({
    consultor: new FormControl(0),
    servico: new FormControl(0),
    data: new FormControl(''),
  });
  feriados: Feriado[] = [];
  
  private dataComponent: AgendamentoComponenteData = {
    servicos: [],
    consultores: []
  };

  public filterData = this.filterDateDefault;

  @Output() filtra: EventEmitter<AgendamentoParamsFilter> = new EventEmitter();

  get servicos(): Servico[] {
    return this.dataComponent.servicos;
  }


  get consultores(): Consultor[] {
    return this.dataComponent.consultores;
  }

  constructor(private consultorRuleService: ConsultorRuleService,
    private servicoService: ServicoService,
    private consultorService: ConsultorService,
    private feriadosService: FeriadosNacionaisService) {
  }

  ngOnInit(): void {
    this.onChanges();
    this.getConsultores();
    this.getServico();
    this.getFeriados();
  }

  filtrar(filtro: AgendamentoParamsFilter) {
    this.filtra.emit(filtro);
  }

  onSubmit() {
    let filtro = this.filtro;
    if (filtro.valid) {
      let data = '';
      if (filtro.value.data) {
        data = new Date(filtro.value.data).toISOString();
      }
      this.filtrar({
        consultorId: filtro.value.consultor,
        servicoId: filtro.value.servico,
        data: data,
      });
    }

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
    const anosAnteriores = [...Array(anosProximos).keys()].reverse().map(decrecimo => (anoAtual-1) - decrecimo);
    this.feriadosService.feriadosMultiplosAnos([...anosAnteriores,...proximosAnos]).subscribe((feriados: Feriado[]) => {
      this.feriados.push(...feriados);
    });

    this.filterData = (d: Date | null): boolean => {
      const date = (d || new Date());
      return this.filtroferiado(d) && this.filterDateDefault(d);
    };
    this.filtro.controls['data'].enable();
  }

  bloquearFeriados() {
    this.filterData = (d: Date | null): boolean => {
      const date = (d || new Date());
      return this.filtroferiado(d) && this.filterDateDefault(d);
    };
    this.filtro.controls['data'].enable();
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

  onChanges(): void {

    this.filtro.valueChanges.subscribe((agendamento: AgendamentoFormData) => {
      this.dataComponent = this.consultorRuleService.controladorFormulario(agendamento, this.dataComponent);
    })
  }
}
