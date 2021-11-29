import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { AbstractControl, FormBuilder, FormControl, FormGroup, NgForm, ValidationErrors, ValidatorFn, Validators } from '@angular/forms';

import { Servico } from 'src/app/models/servico';
import { Consultor } from 'src/app/models/consultor';
import { Agendamento } from 'src/app/models/agendamento';

@Component({
  selector: 'app-agendamento-cadastro',
  templateUrl: './agendamento-cadastro.component.html',
  styleUrls: ['./agendamento-cadastro.component.scss']
})
export class AgendamentoCadastroComponent implements OnInit {

  private _defaultValues: {
    servico: Servico,
    consultor: Consultor,
    email: '',
    dataPicker: ''
  } = {
      servico: {
        id: 0,
        descricao: 'Nenhum'
      },
      consultor: {
        id: 0,
        nome: 'Nenhum',
        email: ''
      },
      email: '',
      dataPicker: ''
    };
  minDate: Date;
  maxDate: Date;

  servicoForm = new FormControl(this._defaultValues.servico, [Validators.required, this.forbiddenId()]);
  consultorForm = new FormControl(this._defaultValues.consultor, [Validators.required, this.forbiddenId()]);
  email = new FormControl(this._defaultValues.email, [Validators.required, Validators.email]);
  dataPicker = new FormControl(this._defaultValues.dataPicker, [Validators.required]);

  cadastro = new FormGroup({
    servico: this.servicoForm,
    consultor: this.consultorForm,
    dataPicker: this.dataPicker,
    email: this.email,
  });

  private _servicos: Servico[] = [this._defaultValues.servico];
  private _consultores: Consultor[] = [this._defaultValues.consultor];

  @Output() agendar = new EventEmitter<Agendamento>();

  @Input()
  set servicos(val: Servico[]) {
    this._servicos = val;
  }

  get servicos(): Servico[] {
    return this._servicos;
  }

  @Input()
  set consultores(val: Consultor[]) {
    this._consultores = val;
  }

  get consultores(): Consultor[] {
    return this._consultores;
  }

  constructor(
    fb: FormBuilder
  ) {
    const currentDate = new Date();
    let _minDate = new Date();
    _minDate.setDate(currentDate.getDate() + 1);
    this.minDate = _minDate;
    let _maxDate = new Date();
    _maxDate.setMonth(currentDate.getMonth()+6);
    this.maxDate = _maxDate;
    console.log(currentDate);
    console.log(this.maxDate);
    console.log(this.minDate);
  }


  ngOnInit(): void {
    this.onChanges();
  }

  cadastrar(agendamento: Agendamento): void {
    this.agendar.emit(agendamento);
  }

  forbiddenId(): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const forbidden = control.value.id === 0;
      return forbidden ? { forbiddenName: { value: control.value } } : null;
    };
  }

  controladorFormulario(agenda: Agendamento, ddd: any): void {
    console.log(agenda);
    console.log(ddd);
    if (agenda.servico.id === 0) {
      return;
    }

    if (agenda.consultor.id === 0) {
      return;
    }
  }

  onChanges(): void {
    this.cadastro.valueChanges.subscribe((agendamento: Agendamento) => {
      console.log('firstname value changed');
      this.controladorFormulario(agendamento, this.cadastro.valid);
    })
  }

  onSubmit(): void {
    const data = this.cadastro.value;

    if (this.cadastro.valid) {
      const date = new Date(data.dataPicker).toISOString();
      let agendamento: Agendamento = {
        consultor: data.consultor,
        data: date,
        email_cliente: data.email,
        servico: data.servico,
      };
      this.cadastrar(agendamento);
    }

  }
}
