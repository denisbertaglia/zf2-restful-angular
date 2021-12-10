import { ChangeDetectionStrategy, Component } from '@angular/core';
import { ServicoService } from 'src/app/services/servico.service';
import { Consultor } from './models/consultor';
import { Servico } from './models/servico';
import { ConsultorService } from './services/consultor.service';
import { AgendamentoService } from './services/agendamento.service';
import { Agendamento } from './models/agendamento';
import { MatDialog } from '@angular/material/dialog';
import { DialogComponent, DialogData } from './views/dialog/dialog.component';
import { ApiError } from './services/api-error';
import { LoadingService } from './services/loading.service';
import { AgendamentoComponenteData } from './views/agendamento-cadastro/agendamento-componente-data';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class AppComponent {
  title = 'Atendimentos';
  servicos: Servico[] = [];
  consultores: Consultor[] = [];
  agendamento: AgendamentoComponenteData ={
    servicos:[],
    consultores:[]
  };

  constructor(
    private servicoService: ServicoService,
    private consultorService: ConsultorService,
    private agendamentoService: AgendamentoService,
    public dialog: MatDialog,
    public loadingService: LoadingService
  ) {
  }

  getServico() {
    this.servicoService.getServico().subscribe((servico: Servico[]) => {
      this.servicos = servico;
      this.agendamento.servicos = servico;
    });
  }

  getConsultores() {
    this.consultorService.getConsultores().subscribe((consultor: Consultor[]) => {
      this.consultores = consultor
      this.agendamento.consultores = consultor;
    });
  }

  openDialog(data: DialogData): void {
    const dialogRef = this.dialog.open(DialogComponent, {
      width: '50%',
      data,
      disableClose: true,
    });
  }

  ngOnInit(): void {
    this.getConsultores();
    this.getServico();
  }

}
