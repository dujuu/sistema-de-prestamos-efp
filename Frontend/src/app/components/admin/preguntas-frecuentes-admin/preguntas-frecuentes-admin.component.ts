import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-preguntas-frecuentes-admin',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './preguntas-frecuentes-admin.component.html',
  styleUrl: './preguntas-frecuentes-admin.component.css'
})
export class PreguntasFrecuentesAdminComponent {

  nuevaPregunta = '';
  nuevaRespuesta = '';

  preguntas = [
    { pregunta: 'Ejemplo: ¿Cómo se registra un préstamo?', respuesta: 'Respuesta ejemplo para administrador.' }
  ];

  agregarPregunta() {
    if (!this.nuevaPregunta || !this.nuevaRespuesta) return;

    this.preguntas.push({
      pregunta: this.nuevaPregunta,
      respuesta: this.nuevaRespuesta
    });

    this.nuevaPregunta = '';
    this.nuevaRespuesta = '';
  }

  eliminarPregunta(index: number) {
    this.preguntas.splice(index, 1);
  }
}
