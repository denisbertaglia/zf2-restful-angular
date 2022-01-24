import { TestBed } from '@angular/core/testing';

import { ConsultorRuleService } from './consultor-rule.service';

describe('ConsultorRuleService', () => {
  let service: ConsultorRuleService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ConsultorRuleService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
