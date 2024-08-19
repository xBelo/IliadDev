import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Order } from '../models/order.model';

@Injectable({
  providedIn: 'root'
})
export class OrderService {

  private apiUrl = 'http://localhost:8000/api/order';

  constructor(private http: HttpClient) {}

  getOrdini(name?: string, description?: string, date?: string): Observable<Order[]> {
    let params = new HttpParams();
    if (name) params = params.set('name', name);
    if (description) params = params.set('description', description);
    if (date) params = params.set('date', date);

    return this.http.get<Order[]>(this.apiUrl, { params });
  }

  getOrder(id: number): Observable<Order> {
    return this.http.get<Order>(`${this.apiUrl}/view/${id}`);
  }

  createOrder(order: Order): Observable<Order> {
    return this.http.post<Order>(`${this.apiUrl}/create`, order);
  }

  updateOrder(id: number, order: Order): Observable<Order> {
    return this.http.put<Order>(`${this.apiUrl}/edit/${id}`, order);
  }

  deleteOrder(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}/delete/${id}`);
  }
}
