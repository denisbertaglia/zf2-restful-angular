import { Injectable, Input } from '@angular/core';
import { AgendamentoComponenteData } from '../views/agendamento-cadastro/agendamento-componente-data';
import { AgendamentoFormData } from '../views/agendamento-cadastro/agendamento-form-data';
 
export class ConsultorRuleService {

  constructor() { }

  controladorFormulario(agenda: AgendamentoFormData, data: AgendamentoComponenteData): AgendamentoComponenteData {
    const servicoId = agenda.servico;
    const consultorId = agenda.consultor;
    const consultor = data.consultores[consultorId];
    if (consultorId !== 0) {
      consultor.servicos?.map((consultorServico) => {
        data.servicos = data.servicos?.map((servico) => {
          if (consultorServico.id !== servico.id && servico.id !== 0) {
            servico.disabled = true;
          } else {
            servico.disabled = false;
          }
          return servico;
        });
      });
    } else {
      data.servicos = data.servicos.map((servico) => {
        servico.disabled = false;
        return servico;
      });
    }

    if (servicoId !== 0) {
      data.consultores = data.consultores.map((consul) => {
        consul.servicos?.map((servicoConsultor) => {
          if (servicoConsultor.id !== servicoId && servicoConsultor.id !== 0) {
            consul.disabled = true;
          } else {
            consul.disabled = false;
          }
        });
        return consul;
      });
    } else {
      data.consultores = data.consultores.map((consul) => {
        consul.servicos?.map((servicoConsultor) => {
          consul.disabled = false;
        });
        return consul;
      });
    }

    if (consultorId === 0 && servicoId === 0) {
      data = this.resetData(data);
    }

    return data;
  }

  public resetData(data: AgendamentoComponenteData):AgendamentoComponenteData {
    data.consultores = data.consultores.map((consultor) => {
      consultor.disabled = false;
      return consultor;
    });
    data.servicos = data.servicos.map((servico) => {
      servico.disabled = false;
      return servico;
    });
    return data;
  }

}
