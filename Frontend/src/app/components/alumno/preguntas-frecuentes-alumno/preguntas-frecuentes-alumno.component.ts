import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-preguntas-frecuentes-alumno',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './preguntas-frecuentes-alumno.component.html',
  styleUrl: './preguntas-frecuentes-alumno.component.css'
})
export class PreguntasFrecuentesAlumnoComponent {

  preguntas = [
    { pregunta: '¿Cómo solicito un equipo?', respuesta: 'Puedes solicitar un equipo desde el módulo de reservas en el menú principal.' },
    { pregunta: '¿Qué pasa si no devuelvo a tiempo?', respuesta: 'El sistema aplicará sanciones según el reglamento del laboratorio.' },
    { pregunta: '¿Dónde veo mis solicitudes?', respuesta: 'En la sección "Mis solicitudes" encontrarás todo tu historial.' }
  ];
}
