import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { catchError, map, retry } from 'rxjs/operators';
import { environment } from '../../environments/environment';
import { Consultor } from '../models/consultor';
import { ApiError } from './api-error';

@Injectable({
  providedIn: 'root'
})
export class ConsultorService {

  url = environment.apiUrl + 'consultores';

  constructor(private httpClient: HttpClient) {
  }

  getConsultores(): Observable<Consultor[]> {
    return this.httpClient.get<any>(this.url)
      .pipe(
        retry(1),
        catchError(this.handleError))
      .pipe(map(data => { return this.setDefault(data.data) }))
  }

  private setDefault(data:Consultor[] ):Consultor[] {
    let consultorDefault:Consultor = {
      id: 0,
      nome: "Nenhum",
      email:""
    } ;
    return [consultorDefault, ...data];
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
