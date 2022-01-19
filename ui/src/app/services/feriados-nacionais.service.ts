import { HttpClient, HttpErrorResponse, HttpHeaders, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { catchError, map, retry } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { Feriado } from '../models/feriado';
import { ApiError } from './api-error';

@Injectable({
  providedIn: 'root'
})
export class FeriadosNacionaisService {
  url = environment.apiFeriados;

  constructor(private httpClient: HttpClient) { }

  httpOptions = {
    headers: new HttpHeaders({ 'Content-type': 'application/json' })
  }

  feriadosPorAno(ano: number): Observable<Feriado[]> {
    return this.httpClient.get<Feriado[]>(this.url + ano)
      .pipe(
        retry(1),
        catchError(this.handleError)
      ).pipe(map(feriados =>
        feriados.map((feriado) => {
          return { ...feriado, date: feriado.date + " 00:00:00" };
        })
      ));
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

    const apiError: ApiError = {
      status: error.status,
      statusText: error.message,
      error: error.error,
      url: error.url,
    }

    return throwError(apiError);
  };
}
