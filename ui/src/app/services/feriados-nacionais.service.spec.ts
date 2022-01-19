import { TestBed } from '@angular/core/testing';

import { FeriadosNacionaisService } from './feriados-nacionais.service';

describe('FeriadosNacionaisService', () => {
  let service: FeriadosNacionaisService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(FeriadosNacionaisService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
