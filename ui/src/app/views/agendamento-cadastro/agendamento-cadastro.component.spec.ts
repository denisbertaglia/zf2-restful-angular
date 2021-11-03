import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AgendamentoCadastroComponent } from './agendamento-cadastro.component';

describe('AgendamentoCadastroComponent', () => {
  let component: AgendamentoCadastroComponent;
  let fixture: ComponentFixture<AgendamentoCadastroComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AgendamentoCadastroComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AgendamentoCadastroComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
