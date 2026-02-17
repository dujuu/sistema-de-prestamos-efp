import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class TipoEquipoService {

  private apiUrl = 'http://127.0.0.1:8000/api';

  constructor(private http: HttpClient) { }

  private getHeaders(): HttpHeaders {
    const token = localStorage.getItem('token') ?? '';
    return new HttpHeaders({
      Authorization: `Bearer ${token}`,
      Accept: 'application/json'
    });
  }

  // ============================================================
  // LISTAR TIPOS DE EQUIPO
  // ============================================================
  getTipos(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/tipoEquipo`, {
      headers: this.getHeaders()
    });
  }

  // ============================================================
  // CREAR NUEVO TIPO (modelo)
  // ============================================================
  crearTipo(data: any, imagen?: File): Observable<any> {

    const formData = new FormData();

    formData.append('nombre', data.nombre);
    formData.append('categoria_id', data.categoria_id);

    if (imagen) formData.append('imagen', imagen);

    return this.http.post(`${this.apiUrl}/tipoEquipo`, formData);
  }

  // ============================================================
  // CATÁLOGO: tipo de equipos + stock
  // ============================================================
  getCatalogo(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/catalogo-equipos`, {
      headers: this.getHeaders()
    });
  }

  // ============================================================
  // LISTAR EQUIPOS FÍSICOS DISPONIBLES POR TIPO
  // ============================================================
  getEquiposPorTipo(idTipo: number): Observable<any[]> {
    return this.http.get<any[]>(
      `${this.apiUrl}/tipoEquipo/${idTipo}/equipos-disponibles`,
      { headers: this.getHeaders() }
    );
  }

  // ============================================================
  // ACTUALIZAR TIPO
  // ============================================================
  actualizarTipo(id: number, data: any): Observable<any> {
    return this.http.put(`${this.apiUrl}/tipoEquipo/${id}`, data, {
      headers: this.getHeaders()
    });
  }

  // ============================================================
  // ELIMINAR TIPO
  // ============================================================
  eliminarTipo(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/tipoEquipo/${id}`, {
      headers: this.getHeaders()
    });

  }



  // ============================================================
  // LISTAR PACKS
  // ============================================================
  getPacks(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/packs`, {
      headers: this.getHeaders()
    });
  }


}
