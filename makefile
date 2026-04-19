install:
	composer install

# ── Code Quality ──────────────────────────────────────────────────────────
check-pr:
	make lint-stable
	make test-fresh

lint-check:
	./vendor/bin/pint --test

lint:
	./vendor/bin/pint --parallel

lint-stable:
	./vendor/bin/pint

lint-uncommited:
	./vendor/bin/pint --dirty

# ── Database ──────────────────────────────────────────────────────────────
db-fresh:
	php artisan migrate:fresh

# ── Testing ───────────────────────────────────────────────────────────────
test:
	php artisan test

test-fresh:
	php artisan migrate:fresh
	php artisan test
