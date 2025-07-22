import { Component } from '@angular/core';
import { CommonModule } from '@angular/common'; 
import { FormsModule } from '@angular/forms'; 


@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  email: string = '';
  password: string = '';
  confirmPassword: string = '';

  onSubmit() {
    console.log('E-Mail:', this.email);
    console.log('Passwort:', this.password);
    console.log('confirmPassword:', this.confirmPassword);
  }
}
