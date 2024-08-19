import { Component, OnInit } from '@angular/core';
import { OrderService } from '../../services/order.service';
import { Order } from '../../models/order.model';
import { HttpClientModule } from '@angular/common/http';
import { Router } from '@angular/router';
import { ClarityModule } from '@clr/angular';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';


@Component({
  selector: 'app-order-list',
  standalone: true,
  imports: [HttpClientModule, ClarityModule, CommonModule, FormsModule],
  templateUrl: './order-list.component.html',
  styleUrl: './order-list.component.css',
  providers: [OrderService]
})
export class OrderListComponent implements OnInit {

  orders: Order[] = [];
  nameFilter: string = '';
  descriptionFilter: string = '';
  dateFilter: string = '';

  constructor(private orderService: OrderService, private router: Router) {}

  ngOnInit(): void {
    this.loadOrders();
  }

  loadOrders() {
    this.orderService.getOrdini(this.nameFilter, this.descriptionFilter, this.dateFilter).subscribe((data: Order[]) => {
      this.orders = data;
    });
  }

  onSearch(): void {
    this.loadOrders();
  }

  deleteOrder(id: number): void {
    this.orderService.deleteOrder(id).subscribe(() => {
      window.alert('Ordine cancellato con successo!');
      this.loadOrders(); // Ricarica gli ordini dopo l'eliminazione
    });
  }

  viewOrder(id: number): void {
    this.router.navigate([`/api/order/view/${id}`]);
  }

  editOrder(id: number): void {
    this.router.navigate([`/api/order/edit/${id}`]);
  }

  createOrder(): void {
    this.router.navigate(['/api/order/create']);
  }

  onResetFilters(): void {
    this.nameFilter = '';
    this.descriptionFilter = '';
    this.dateFilter = '';
    this.loadOrders();
  }
}