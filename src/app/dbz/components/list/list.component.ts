import { Component, OnDestroy, OnInit  } from '@angular/core';
import { Subscription } from 'rxjs';
import { Personaje } from '../../interfaces/character.interface';
import { DbzService } from '../../services/dbz.service';

@Component({
  selector: 'dbz-list',
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.css']
})
export class ListComponent implements OnInit, OnDestroy {
  public personajes: Personaje[] = []; // Objeto vinculado al .html
  private suscripcion: Subscription | null = null;

  constructor(private dbzService: DbzService) { }

  ngOnInit() {
    this.suscripcion = this.dbzService.personajes$.subscribe(
      personajesActualizados => {
        this.personajes = personajesActualizados;
      }
    );
  }

  ngOnDestroy() {
    if (this.suscripcion !== null) {
      this.suscripcion.unsubscribe(); // Evita fugas de memoria al destruir el componente
    } 
    // Tambien: this.suscripcion?.unsubscribe();
  }

  enviarId(id: number): void { // Envio el id del personaje a través del Servicio
    console.log("Desde 'Listado' envio: ", id);
    this.dbzService.borrarPersonaje(id);
  }

  enviarPersonaje(id: number, personaje: Personaje): void { // Envio el id y personaje a través del Servicio
    console.log("Desde 'Listado' envio: ", id);
    this.dbzService.borrarPersonaje(id);
    this.dbzService.actualizarPersonaje(personaje);
  }
}
