import { HttpClient, HttpErrorResponse, HttpHeaders, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { catchError, map, retry } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { Agendamento } from '../models/agendamento';
import { ApiError } from './api-error';

export interface AgendamentoParamsFilter{
  consultorId?:number;
  servicoId?:number;
  data?:string;
}

@Injectable({
  providedIn: 'root'
})
export class AgendamentoService {

  url = environment.apiUrl + 'agendamento';

  constructor(private httpClient: HttpClient) { }

  httpOptions = {
    headers: new HttpHeaders({ 'Content-type': 'application/json' })
  }

  postAgendamento(agendamento: Agendamento): Observable<any> {
    return this.httpClient.post<any>(this.url, agendamento)
      .pipe(
        retry(1),
        catchError(this.handleError)
      )
      .pipe(map(data => { return data.data }));
  }

  listAgendamento(filter: AgendamentoParamsFilter): Observable<Agendamento[]> {

    let params = new HttpParams();
    if( filter.consultorId !== undefined){
      params = params.set("consultorId",filter.consultorId);
    }
    if( filter.servicoId !== undefined){
      params = params.set("servicoId",filter.servicoId);
    }
    if( filter.data !== undefined){
      params = params.set("data",filter.data);
    }

    return this.httpClient.get<any>(this.url,{params: params})
      .pipe(
        retry(1),
        catchError(this.handleError)
      )
      .pipe(map(data => { return data.data }));
  }

  handleError(error: HttpErrorResponse, x: any) {

    let errorMessage = '';
    if (error.error instanceof ErrorEvent) {
      // Erro ocorreu no lado do client
      errorMessage = error.error.message;
    } else {
      // Erro ocorreu no lado do servidor
      errorMessage = `Código do erro: ${error.status}, ` + `menssagem: ${error.message}`;
    }
    console.log(errorMessage);

    const apiError: ApiError = {
      status: error.status,
      statusText: error.statusText,
      error: error.error,
      url: error.url,
    }

    return throwError(apiError);
  };

}
