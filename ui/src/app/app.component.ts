import { Component } from '@angular/core';
import { ServicoService } from 'src/app/services/servico.service';
import { Consultor } from './models/consultor';
import { Servico } from './models/servico';
import { ConsultorService } from './services/consultor.service';
import { AgendamentoService } from './services/agendamento.service';
import { Agendamento } from './models/agendamento';
import { MatDialog } from '@angular/material/dialog';
import { DialogComponent, DialogData } from './views/dialog/dialog.component';
import { ApiError } from './services/api-error';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'Atendimentos';
  servicos: Servico[] = [];
  consultores: Consultor[] = [];

  constructor(
    private servicoService: ServicoService,
    private consultorService: ConsultorService,
    private agendamentoService: AgendamentoService,
    public dialog: MatDialog
  ) {
  }

  getServico() {
    this.servicoService.getServico().subscribe((servico: Servico[]) => {
      this.servicos = servico
    });
  }

  getConsultores() {
    this.consultorService.getConsultores().subscribe((consultor: Consultor[]) => {
      this.consultores = consultor
    });
  }

  doAgendamento(agendamento: Agendamento) {
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

  openDialog(data: DialogData): void {
    const dialogRef = this.dialog.open(DialogComponent, {
      width: '50%',
      data,
    });
  }

  ngOnInit(): void {
    this.getConsultores();
    this.getServico();
  }

}
