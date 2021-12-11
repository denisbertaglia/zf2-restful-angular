import { Consultor } from "src/app/models/consultor";
import { Servico } from "src/app/models/servico";

export interface AgendamentoFormData{
    consultor: Consultor['id'];
    data: string;
    email_cliente?: string;
    servico: Servico['id'];
}
