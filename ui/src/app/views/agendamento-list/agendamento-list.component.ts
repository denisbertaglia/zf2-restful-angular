import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

import { AGENDAMENTOS } from 'src/app/mocks/agendamento/mock-agendamento';
import { Servico } from 'src/app/models/servico';
import { Consultor } from 'src/app/models/consultor';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { AgendamentoComponenteData } from '../agendamento-cadastro/agendamento-componente-data';
import { AgendamentoService } from 'src/app/services/agendamento.service';
import { ConsultorRuleService } from 'src/app/services/consultor-rule.service';
import { AgendamentoFormData } from '../agendamento-cadastro/agendamento-form-data';

import { AgendamentoParamsFilter } from 'src/app/services/agendamento-params-filter';
import { Agendamento } from 'src/app/models/agendamento';


@Component({
  selector: 'app-agendamento-list',
  templateUrl: './agendamento-list.component.html',
  styleUrls: ['./agendamento-list.component.scss']
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

  private _dataComponent: AgendamentoComponenteData = {
    servicos: [],
    consultores: []
  };

  @Output() filtra: EventEmitter<AgendamentoParamsFilter> = new EventEmitter();

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
    private consultorService: ConsultorRuleService) { }

  ngOnInit(): void {
    this.onChanges();
  }

  filtrar(filtro: AgendamentoParamsFilter) {
    this.filtra.emit(filtro);
  }

  onSubmit() {
    let filtro = this.filtro;
    if (filtro.valid) {
      let data = '';
      if (filtro.value.data !== '') {
        data = new Date(filtro.value.data).toISOString();
      }
      this.filtrar({
        consultorId: filtro.value.consultor,
        servicoId: filtro.value.servico,
        data: data,
      });
    }

  }

  onChanges(): void {
    this.filtro.valueChanges.subscribe((agendamento: AgendamentoFormData) => {
      this._dataComponent = this.consultorService.controladorFormulario(agendamento, this._dataComponent);
    })
  }
}
