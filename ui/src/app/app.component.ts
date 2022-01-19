import { ChangeDetectionStrategy, Component } from '@angular/core';
import { ServicoService } from 'src/app/services/servico.service';
import { Consultor } from './models/consultor';
import { Servico } from './models/servico';
import { ConsultorService } from './services/consultor.service';
import { AgendamentoService } from './services/agendamento.service';
import { Agendamento } from './models/agendamento';
import { MatDialog } from '@angular/material/dialog';
import { DialogComponent, DialogData } from './views/dialog/dialog.component';
import { LoadingService } from './services/loading.service';
import { AgendamentoComponenteData } from './views/agendamento-cadastro/agendamento-componente-data';
import { AgendamentoParamsFilter } from './services/agendamento-params-filter';
import { FeriadosNacionaisService } from './services/feriados-nacionais.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush
})

export class AppComponent {
  title = 'Atendimentos';
  agendamentoList: Agendamento[] = [];
  constructor(
    private agendamentoService: AgendamentoService,
    public dialog: MatDialog,
    public loadingService: LoadingService,
    private feriadosService: FeriadosNacionaisService
  ) {
  }

  getFeriados() {
    this.feriadosService.feriadosPorAno(2020).subscribe((data: any) => {
      console.log(data);
    })
  }

  getAgendamento(filterData: AgendamentoParamsFilter) {
    this.agendamentoService.listAgendamento(filterData).subscribe((agendamento: Agendamento[]) => {
      this.agendamentoList = agendamento;
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
    this.getFeriados();
  }

}
