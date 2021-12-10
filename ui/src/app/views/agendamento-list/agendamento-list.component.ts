import { Component, OnInit, Input } from '@angular/core';

import { AGENDAMENTOS } from 'src/app/mocks/agendamento/mock-agendamento';
import { CONSULTOR } from '../../mocks/consultor/mock-consutor';
import { SERVICO } from 'src/app/mocks/servicos/mock-servico';
import { Servico } from 'src/app/models/servico';
import { Consultor } from 'src/app/models/consultor';
import { FormControl } from '@angular/forms';
import { AgendamentoComponenteData } from '../agendamento-cadastro/agendamento-componente-data';


@Component({
  selector: 'app-agendamento-list',
  templateUrl: './agendamento-list.component.html',
  styleUrls: ['./agendamento-list.component.scss']
})
export class AgendamentoListComponent implements OnInit {

  agendamentos = AGENDAMENTOS;

  servicoEscolhido = new FormControl(0);
  consultorEscolhido = new FormControl(0);

  private _dataComponent: AgendamentoComponenteData = {
    servicos: [],
    consultores: []
  };

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

  constructor() { }

  ngOnInit(): void {

  }

}
