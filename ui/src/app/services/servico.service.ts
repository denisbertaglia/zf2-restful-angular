import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { retry, catchError } from 'rxjs/operators';
import { Servico } from '../models/servico';
import { environment } from '../../environments/environment';
import { map } from 'rxjs/operators';
import { ApiError } from './api-error';
import { Consultor } from '../models/consultor';

export interface ServiceParamsFilter{
  consultorId?:number
}

@Injectable({
  providedIn: 'root'
})
export class ServicoService {

  url = environment.apiUrl + 'servicos';

  constructor(private httpClient: HttpClient) {
  }

  httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  }

  getServico(filter:ServiceParamsFilter = {}): Observable<Servico[]> {
    let params = new HttpParams();
    if( filter.consultorId !== undefined){
      console.log(filter);
      params = params.set("consultorId",filter.consultorId);
    }
    
    return this.httpClient.get<any>(this.url,{params: params})
      .pipe(
        retry(2),
        catchError(this.handleError))
      .pipe(map(data => { return this.setDefault(data.data) }))
  }

  getServicoByConsultor(id:number): Observable<Servico[]>  {
    return this.getServico({ consultorId: id });
  }

  private setDefault(data:Servico[] ):Servico[] {
    let serviceDefault:Servico = {
      id: 0,
      descricao: "Nenhum"
    } ;
    return [serviceDefault, ...data];
  }

  handleError(error: HttpErrorResponse) {
    let errorMessage = '';
    if (error.error instanceof ErrorEvent) {
      // Erro ocorreu no lado do client
      errorMessage = error.error.message;
    } else {
      // Erro ocorreu no lado do servidor
      errorMessage = `Código do erro: ${error.status}, ` + `menssagem: ${error.message}`;
    }
    console.log(errorMessage);
    const apiError: ApiError ={
      status: error.status,
      statusText: error.statusText,
      error: error.error,
      url: error.url,
    }

    return throwError(apiError);
  };
}
