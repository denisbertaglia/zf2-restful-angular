import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { LoadingService } from '../services/loading.service';
import { finalize } from 'rxjs/operators';

@Injectable()
export class LoadingInterceptor implements HttpInterceptor {
  private totalRequests = 0;
  constructor(private loadingService: LoadingService) { }

  intercept(request: HttpRequest<any>, next: HttpHandler) {
    this.totalRequests++;
    this.loadingService.setLoading(true);
    return next.handle(request).pipe(
      finalize(() =>{
        this.totalRequests--;
        if (this.totalRequests === 0) {
          this.loadingService.setLoading(false);
        }
      })
    )
    return next.handle(request);
  }
}
