## CRUD Laravel

### OBJETIVO: criar uma base de dados.

### Parte 1

Desenvolva um CRUD (create, read, update, delete) que recebe json e retorna json, ou seja, uma API RESTful de Funcionários. Contento os seguintes campos: id, nome, sobrenome, idade e sexo.

### Parte 2

Desenvolva um endpoint que retorna um relatório com:

-   a quantidade de funcionários do sexo masculino e do sexo feminino
-   média de idade dos(as) funcionários(as)
-   idade do funcionário(a) mais novo(a) e idade do funcionário(a) mais velho (a)

### Resumo

Sua aplicação deve conter no mínimo:
4 endpoints para:

-   Cadastrar;
-   Editar;
-   Remover;
-   Retornar dados de um funcionário(a).

1 endpoint para retornar dados de relatório dos funcionários, contendo:

-   Quantidade de funcionários do sexo masculino;
-   Quantidade de funcionárias do sexo feminino;
-   Média de idade dos funcionários(as);
-   Idade do funcionário(a) mais novo(a);
-   Idade do funcionário(a) mais velho(a).

## ROTAS APLICAÇÃO

PAGINAS USUÁRIO:

-   Route::get('/usuario-lista', 'Usuario@lista')->name('usuario.lista');
-   Route::get('/usuario-add', 'Usuario@add')->name('usuario.add');
-   Route::get('/usuario-edit/{id?}', 'Usuario@edit')->name('usuario.edit');
-   Route::post('/usuario-store', 'Usuario@store')->name('usuario.store');
-   Route::post('/usuario-update/{id}', 'Usuario@update')->name('usuario.update');
-   Route::get('/usuario-delete/{id}', 'Usuario@delete')->name('usuario.delete');

PAGINAS ANALISE

-   Route::get('/analise', 'Analise@index')->name('analise');
-   Route::get('/analise/dados', 'Analise@dados')->name('analise.dados');
