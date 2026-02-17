/**
 * Servicio responsable de gestionar todas las operaciones relacionadas
 * con equipos dentro del sistema. Actúa como capa intermediaria entre
 * los componentes de Angular y el backend Laravel, encapsulando las
 * solicitudes HTTP y garantizando una comunicación estructurada,
 * segura y reutilizable.
 *
 * Este servicio implementa funcionalidades clave:
 *  - Obtener el listado completo de equipos.
 *  - Consultar un equipo específico por ID.
 *  - Registrar nuevos equipos.
 *  - Actualizar información existente.
 *  - Eliminar equipos de la base de datos.
 *
 * El uso de este servicio permite mantener un frontend desacoplado,
 * limpio y fácil de mantener, siguiendo buenas prácticas como
 * separación de responsabilidades (SRP) y centralización de lógica
 * de comunicación.
 */
import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class EquiposService {

  private apiUrl = 'http://127.0.0.1:8000/api';
  private apiUrl2 = 'http://127.0.0.1:9000/api';

  constructor(private http: HttpClient) {}
  /**
   * Genera los encabezados necesarios para las solicitudes HTTP,
   * incluyendo el token de autenticación almacenado en el navegador.
   *
   * @returns HttpHeaders Encabezados personalizados con token JWT.
   */
  private getHeaders(): HttpHeaders {
    const token = localStorage.getItem('token') ?? '';
    return new HttpHeaders({
      Authorization: `Bearer ${token}`,
      Accept: 'application/json'
    });
  }

  /**
   * Obtiene el listado completo de equipos desde el backend.
   * Los datos ya vienen formateados con nombre de modelo y categoría.
   *
   * @returns Observable<any[]> Listado de equipos.
   */
  getEquipos(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/equipos`, {
      headers: this.getHeaders()
    });
  }

  // Obtener un equipo por ID
  getEquipo(id: number): Observable<any> {
    return this.http.get(`${this.apiUrl}/equipos/${id}`, {
      headers: this.getHeaders()
    });
  }

/**
 * Envía al backend una solicitud para crear un nuevo equipo.
 *
 * Este método forma parte del flujo principal de creación en el módulo
 * de inventario. Recibe los datos del formulario y los envía mediante
 * una petición HTTP POST hacia el endpoint `/equipos`, junto con los
 * encabezados necesarios para la autenticación (token JWT).
 *
 * La responsabilidad del método es encapsular la comunicación con el backend,
 * manteniendo el componente desacoplado y garantizando una arquitectura limpia.
 *
 * @param data Objeto con los datos del nuevo equipo (tipo_equipo_id, código y estado).
 * @returns Observable<any> Respuesta del servidor tras intentar crear el equipo.
 */
  crearEquipo(data: any): Observable<any> {
    return this.http.post(`${this.apiUrl2}/equipos`, data, {
      headers: this.getHeaders()
    });
  }

  // Actualizar equipo
  actualizarEquipo(id: number, data: any): Observable<any> {
    return this.http.put(`${this.apiUrl}/equipos/${id}`, data, {
      headers: this.getHeaders()
    });
  }

  // Eliminar equipo
  eliminarEquipo(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/equipos/${id}`, {
      headers: this.getHeaders()
    });
  }

  updateEquipo(id: number, data: any) {
   return this.http.put(`${this.apiUrl}/equipos/${id}`, data);
  }

}
