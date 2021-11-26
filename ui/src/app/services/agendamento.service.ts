import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { catchError, map, retry } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { Agendamento } from '../models/agendamento';
import { ApiError } from './api-error';

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
      .pipe(map(data => { return data }));
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
