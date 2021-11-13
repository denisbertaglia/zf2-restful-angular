import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';

import { CONSULTOR } from '../../mocks/consultor/mock-consutor';
import { SERVICO } from 'src/app/mocks/servicos/mock-servico';

import { ServicoService } from 'src/app/services/servico.service';
import { Servico } from 'src/app/models/servico';

@Component({
  selector: 'app-agendamento-cadastro',
  templateUrl: './agendamento-cadastro.component.html',
  styleUrls: ['./agendamento-cadastro.component.scss']
})
export class AgendamentoCadastroComponent implements OnInit {

  name = new FormControl('');
  consultores = CONSULTOR;
   servicos: Servico[] = [];


  constructor(private servicoService: ServicoService) {
    
   }

   getServico() {
    this.servicoService.getServico().subscribe((servico: Servico[]) => {
     this.servicos = servico
    });
  }

  ngOnInit(): void {
    this.getServico();
  }

}
