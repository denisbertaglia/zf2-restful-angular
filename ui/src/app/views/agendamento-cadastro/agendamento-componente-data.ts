
import { Consultor } from "src/app/models/consultor";
import { Servico } from "src/app/models/servico";

export interface AgendamentoComponenteData{
    consultores: Consultor[];
    servicos: Servico[];
}
