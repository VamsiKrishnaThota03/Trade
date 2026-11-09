-- Optional demo data for local development. Run after schema.sql:
--   mysql -u root -p project < seed.sql
-- Demo login: demo@example.com / demo12345  (local use only; delete before deploying)

INSERT INTO user (email, uname, uage, usex, password, ucity, upincode, uphone, country) VALUES
    ('demo@example.com', 'Demo Trader', 30, 'other', '$2y$12$2Kdfs/IgAAMYaTmMMH27QuB8i0a.rjAETdjY6vAIYr37b1h4dZ32i', 'Jabalpur', '482005', '9876543210', 'India');

INSERT INTO available (email, ptype, pname, country, qty, price) VALUES
    ('demo@example.com', 'Grain',    'Basmati rice',     'India',     120, 95.00),
    ('demo@example.com', 'Grain',    'Durum wheat',      'Canada',     80, 42.50),
    ('demo@example.com', 'Spices',   'Black pepper',     'India',      35, 610.00),
    ('demo@example.com', 'Textiles', 'Cotton yarn',      'Bangladesh', 200, 18.75),
    ('demo@example.com', 'Steel',    'Hot-rolled coil',  'Japan',      60, 720.00);
