import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AsignaturasService {

  private api = 'http://localhost:8000/api'; // TU BACKEND LARAVEL

  constructor(private http: HttpClient) {}

  /* ===========================
        EQUIPOS / ASIGNATURAS
  ============================ */

  getEquipos(): Observable<any> {
    return this.http.get(`${this.api}/equipos`);
  }

  getAsignaturas(): Observable<any> {
    return this.http.get(`${this.api}/asignaturas`);
  }

  /* ===========================
        EVENTOS (NO EXISTEN EN BACKEND)
        → SE SIMULAN AQUÍ
  ============================ */
  getEventos(): Observable<any> {
    return new Observable(sub => {
      sub.next([
        { id: 1, nombre: 'Feria de Diseño' },
        { id: 2, nombre: 'Workshop Multimedia' },
        { id: 3, nombre: 'Charla Audiovisual' }
      ]);
      sub.complete();
    });
  }

  /* ===========================
        CRUD de Restricciones (NO USADO AHORA)
  ============================ */
  getRestricciones(): Observable<any> {
    return this.http.get(`${this.api}/restricciones`);
  }

  crearRestriccion(data: any): Observable<any> {
    return this.http.post(`${this.api}/restricciones`, data);
  }

  actualizarRestriccion(data: any): Observable<any> {
    return this.http.put(`${this.api}/restricciones/${data.id}`, data);
  }

  eliminarRestriccion(id: number): Observable<any> {
    return this.http.delete(`${this.api}/restricciones/${id}`);
  }
}
