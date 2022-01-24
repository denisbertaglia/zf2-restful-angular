import { Servico } from './servico';
import { Consultor } from './consultor';

export interface Agendamento {
    id?: number;
    consultor: Consultor;
    data: string;
    servico: Servico;
    email_cliente: string;
}