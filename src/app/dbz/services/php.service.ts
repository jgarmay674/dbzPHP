import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Personaje } from '../interfaces/character.interface';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  private baseUrl = 'https://cpifpdwec.000webhostapp.com/API'; // Asegúrate de cambiar esto por tu URL real

  constructor(private http: HttpClient) { }

  obtenerPersonajes(): Observable<Personaje[]> {
    return this.http.get<Personaje[]>(`${this.baseUrl}/leer.php`);
  }

  anadirPersonaje(personaje: Personaje): Observable<Personaje> {
    console.log('Enviando personaje:', personaje);
    return this.http.post<Personaje>(`${this.baseUrl}/grabar.php`, personaje);
  }

  borrarPersonaje(id: number): Observable<any> {
    console.log('Eliminando personaje con id:', id);
    return this.http.post(`${this.baseUrl}/borrar.php`, { id });
  }
}