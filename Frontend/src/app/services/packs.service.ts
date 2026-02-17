import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PacksService {

  private api = 'http://localhost:3000/api/packs'; // AJUSTAR SEGÚN TU BACKEND

  constructor(private http: HttpClient) {}

  getPacks(): Observable<any> {
    return this.http.get(this.api);
  }

  createPack(data: any): Observable<any> {
    return this.http.post(this.api, data);
  }

  deletePack(id: number): Observable<any> {
    return this.http.delete(`${this.api}/${id}`);
  }
}
