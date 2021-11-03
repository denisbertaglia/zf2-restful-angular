import { Component, OnInit } from '@angular/core';

import { AGENDAMENTOS } from 'src/app/mocks/agendamento/mock-agendamento';
import { CONSULTOR } from '../../mocks/consultor/mock-consutor';
import { SERVICO } from 'src/app/mocks/servicos/mock-servico';


@Component({
  selector: 'app-agendamento-list',
  templateUrl: './agendamento-list.component.html',
  styleUrls: ['./agendamento-list.component.scss']
})
export class AgendamentoListComponent implements OnInit {

  agendamentos = AGENDAMENTOS;

  consultores = CONSULTOR;
  servicos = SERVICO;

  constructor() { }

  ngOnInit(): void {
  }

}
