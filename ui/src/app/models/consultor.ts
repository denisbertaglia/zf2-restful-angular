import { Servico } from "./servico";

export interface Consultor{
    id: number;
    nome: string;
    email: string;
    servicos?: Servico[];
    disabled?: boolean;
}