<?php

 namespace AgendaApi\Model;

 interface AgendamentoInterface
 {
     /**
      * Irá retornar o identificador do agendamento
      *
      * @return int
      */
     public function getId();

     /**
      * Irá retornar a data do agendamento
      *
      * @return string
      */
     public function getData();

     /**
      * Irá retornar qual consultor vinculado ao agendamento
      *
      * @return string
      */
     public function getConsultor();

     /**
      * Irá retornar qual serviço relacionado ao agendamento
      *
      * @return string
      */
     public function getServico();

     /**
      * Irá retornar o email do cliente agendado
      *
      * @return string
      */
     public function getEmailCliente();
 }