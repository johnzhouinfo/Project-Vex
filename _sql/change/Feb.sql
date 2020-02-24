-- Test product page
INSERT INTO public.vex_product(user_id, product_name, code, create_time)
VALUES (2, 'test', '<!DOCTYPE html>
<html>
<body>

<h1>My First Heading</h1>
<p>My first paragraph.</p>

</body>
</html>', '2020-02-20 23:20:20');

INSERT INTO public.vex_product(user_id, product_name, code, create_time, is_live, is_delete)
VALUES (2, 'test2', '<!DOCTYPE html>
<html>
<body>

<h1>My First Heading2</h1>
<p>My first paragraph.</p>

</body>
</html>', '2020-02-20 23:20:20', true, true);

INSERT INTO public.vex_product(user_id, product_name, code, create_time, is_live, is_delete)
VALUES (2, 'test3', '<!DOCTYPE html>
<html>
<body>

<h1>My First Heading3</h1>
<p>My first paragraph.</p>

</body>
</html>', '2020-02-20 23:20:20', true, false);