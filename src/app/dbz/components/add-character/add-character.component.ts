import { Component, OnInit, OnDestroy } from '@angular/core';
import { Subscription } from 'rxjs';
import { Personaje } from '../../interfaces/character.interface';
import { DbzService } from '../../services/dbz.service';

@Component({
  selector: 'dbz-add-character',
  templateUrl: './add-character.component.html',
  styleUrls: ['./add-character.component.css']
})
export class AddCharacterComponent implements OnInit, OnDestroy{
  public personaje: Personaje = { nombre: '', fuerza: 0 }; // Objeto vinculado al .html
  private suscripcion: Subscription | null = null;

  constructor(private dbzService: DbzService) { }

  ngOnInit() {
    this.suscripcion = this.dbzService.personaje$.subscribe(personaje => {
      this.personaje = personaje;
    });
  }

  ngOnDestroy() {
    if (this.suscripcion !== null) {
      this.suscripcion.unsubscribe(); // Evita fugas de memoria al destruir el componente
    } 
    // Tambien: this.suscripcion?.unsubscribe();
  }

  envioPersonaje(): void { // Envio al personaje a través del Servicio
    console.log("Desde 'Agregar personaje' envio: ", this.personaje);
    this.dbzService.anadirPersonaje(this.personaje);
    this.personaje = { nombre: '', fuerza: 0 };
  }
}
