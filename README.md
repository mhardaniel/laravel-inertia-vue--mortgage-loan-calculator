## Requirements

https://laravel.com/docs/10.x/installation#getting-started-on-windows

-   Docker Desktop
-   WSL

## Running

1. open your terminal
2. git clone https://github.com/mhardaniel/mortgage-loan-calculator.git
3. cd mortgage-loan-calculator
4. cp .env.example .env
5. php artisan key:generate
6. ./vendor/bin/sail up
7. php artisan migrate
8. you can access the application in your web browser at: http://localhost
9. Fill all required fields then click Calculate button to generate Payment Breakdown
10. You can add extra payments on the form to see the recalculated Amortization

### Thank you, Regards

mhardaniel
