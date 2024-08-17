import { Component, OnInit } from '@angular/core';
import { OrderService } from '../../services/order.service';
import { Order } from '../../models/order.model';
import { HttpClientModule } from '@angular/common/http';

@Component({
  selector: 'app-order-list',
  standalone: true,
  imports: [HttpClientModule],
  templateUrl: './order-list.component.html',
  styleUrl: './order-list.component.css',
  providers: [OrderService]
})
export class OrderListComponent implements OnInit {

  order: Order[] = [];

  constructor(private orderService: OrderService) {}

  ngOnInit(): void {
    this.loadOrders();
  }

  loadOrders() {
    this.orderService.getOrdini().subscribe((data: Order[]) => {
      this.order = data;
    });
  }
}