import { Injectable } from '@angular/core';
import { Personaje } from '../interfaces/character.interface';
import { BehaviorSubject, Subject } from 'rxjs';
import { ApiService } from './php.service';
import { tap } from 'rxjs/operators'; // Importa el operador 'tap'

@Injectable({
  providedIn: 'root'
})

export class DbzService {
  private _personajes: BehaviorSubject<Personaje[]> = new BehaviorSubject<Personaje[]>([]); // Lista de personajes
  private _personaje = new Subject<Personaje>(); // Personaje que actualizo
  // Observables
  personajes$ = this._personajes.asObservable();
  personaje$ = this._personaje.asObservable();

  constructor(private apiService: ApiService) { 
    this.cargarPersonajes();
  }

  cargarPersonajes() {
    this.apiService.obtenerPersonajes().pipe(
      tap((personajes: Personaje[]) => {
        this._personajes.next(personajes);
      })
    ).subscribe();
    console.log("La Consulta a la BD devuelve: ", this._personajes);
  }

  // add-character.component.ts
  anadirPersonaje(personaje: Personaje) {
    console.log("Uso servicio 'Añadir personaje' para enviar: ", personaje);
    this.apiService.anadirPersonaje(personaje).subscribe({
      next: () => {
        this.cargarPersonajes(); // Recargar la lista completa desde el servidor
      },
      error: (error: any) => {
        console.error("Error al añadir personaje:", error);
      }
    });
  }

  // list.component.ts
  borrarPersonaje(id: number) {
    console.log("Uso servicio 'Borrar personaje' para borrar: ", id);
    this.apiService.borrarPersonaje(id).subscribe({
      next: () => {
        this.cargarPersonajes(); // Recargar la lista completa desde el servidor
      },
      error: (error: any) => {
        console.error("Error al borrar personaje:", error);
      }
    });
  }
  actualizarPersonaje(personaje: Personaje) {
    this._personaje.next(personaje); // Actualización de personaje
  }                                    
}
