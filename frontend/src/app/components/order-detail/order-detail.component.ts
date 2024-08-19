import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { OrderService } from '../../services/order.service';
import { Order } from '../../models/order.model';
import { HttpClientModule } from '@angular/common/http';
import { ClarityModule } from '@clr/angular';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-order-detail',
  standalone: true,
  templateUrl: './order-detail.component.html',
  imports: [HttpClientModule, ClarityModule, CommonModule],
  styleUrls: ['./order-detail.component.css']
})
export class OrderDetailComponent implements OnInit {
  order: Order | null = null;
  error: string | null = null;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private orderService: OrderService
  ) {}

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.orderService.getOrder(+id).subscribe({
        next: (data) => this.order = data,
        error: (err) => this.error = 'Failed to load order details'
      });
    }
  }

  goToEditOrder(): void {
    if (this.order) {
      this.router.navigate(['/api/order/edit', this.order.id]);
    }
  }

  goToHome(): void {
    this.router.navigate(['/api/order']);
  }
}
