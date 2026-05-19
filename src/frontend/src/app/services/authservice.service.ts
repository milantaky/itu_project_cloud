import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthserviceService {
  private apiUrlRegister =   'https://hw2-backend-takac-cxejfpb3bqg2bdh8.swedencentral-01.azurewebsites.net/api/register';
  private apiUrlLogin =      'https://hw2-backend-takac-cxejfpb3bqg2bdh8.swedencentral-01.azurewebsites.net/api/login';
  private apiUrlUpdateUser = 'https://hw2-backend-takac-cxejfpb3bqg2bdh8.swedencentral-01.azurewebsites.net/api/update-user';
  private apiUrlGetUser = 'https://hw2-backend-takac-cxejfpb3bqg2bdh8.swedencentral-01.azurewebsites.net/api/get-user';
  private apiUrlLoadBalance = 'https://hw2-backend-takac-cxejfpb3bqg2bdh8.swedencentral-01.azurewebsites.net/api/user-balance';

  constructor(private http: HttpClient) { }

  register(information: any): Observable<any> {
    return this.http.post(this.apiUrlRegister, information);
  }

  login(credentials: any): Observable<any> {
    const Credentials = {
      user_email: credentials.email,
      user_password: credentials.password
    };
    return this.http.post(this.apiUrlLogin, Credentials);
  }

  editUser(userInformation: FormData): Observable<any> {
    return this.http.post(this.apiUrlUpdateUser, userInformation);
  }

  loadInfoAboutUser(user_id: number): Observable<any> {
    const params = { user_id: user_id.toString() };
    return this.http.get(this.apiUrlGetUser, { params });
  }

  loadBalance(user_id: number): Observable<any> {
    const params = { user_id: user_id.toString() };
    return this.http.get(this.apiUrlLoadBalance, { params });
  }
  
}
