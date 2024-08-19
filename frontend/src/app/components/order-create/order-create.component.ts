import { Component } from '@angular/core';
import { ActivatedRoute, Router, RouterLink, RouterOutlet } from '@angular/router';
import { OrderService } from '../../services/order.service';
import { HttpClientModule } from '@angular/common/http';
import { ClarityModule } from '@clr/angular';
import { CommonModule } from '@angular/common';
import { Order } from '../../models/order.model';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-order-create',
  standalone: true,
  imports: [HttpClientModule, ClarityModule, CommonModule, FormsModule, RouterLink, RouterOutlet],
  templateUrl: './order-create.component.html',
  styleUrls: ['./order-create.component.css']
})
export class OrderCreateComponent {
  order: Order = {
    id: 0,
    name: '',
    description: '',
    date: new Date,
    products: null
  };

  constructor(private orderService: OrderService, private router: Router) {}

  onSubmit() {
    this.orderService.createOrder(this.order).subscribe((createdOrder) => {
      this.router.navigate(['/orders/view', createdOrder.id]);
    });
    //this.orderService.createOrder(this.order).subscribe(
    //  error => console.error('Error updating order:', error)
    //);
  }
}
