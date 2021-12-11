import { Component, OnInit, Input } from '@angular/core';

import { AGENDAMENTOS } from 'src/app/mocks/agendamento/mock-agendamento';
import { Servico } from 'src/app/models/servico';
import { Consultor } from 'src/app/models/consultor';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { AgendamentoComponenteData } from '../agendamento-cadastro/agendamento-componente-data';
import { AgendamentoService } from 'src/app/services/agendamento.service';
import { ConsultorRuleService } from 'src/app/services/consultor-rule.service';
import { AgendamentoFormData } from '../agendamento-cadastro/agendamento-form-data';


@Component({
  selector: 'app-agendamento-list',
  templateUrl: './agendamento-list.component.html',
  styleUrls: ['./agendamento-list.component.scss']
})
export class AgendamentoListComponent implements OnInit {

  agendamentos = AGENDAMENTOS;

  cadastro = new FormGroup({
    consultor: new FormControl(0, [ Validators.min(1)]),
    servico: new FormControl(0, [Validators.min(1)]),
  });

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

  constructor(
    private agendamentoService: AgendamentoService,
    private consultorService:ConsultorRuleService) { }

  ngOnInit(): void {
    this.onChanges();
  } 

  onSubmit(){

  }

  onChanges(): void {
    this.cadastro.valueChanges.subscribe((agendamento: AgendamentoFormData) => {
      this._dataComponent = this.consultorService.controladorFormulario(agendamento, this._dataComponent);
    })
  }
}
