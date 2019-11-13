# shopify

Integração da ferramenta shopify

Nem todos os campos são obrigatorio.

***Adicionar os Products***

-title

não pode ficar vazio

***Adicionar os Costumers***

-Nome

-telefone 

-email 

não pode ficar vazio

***Adicionar os Order***

-Nome

-telefone 

-email 

não pode ficar vazio

Mostra informações use var_dump ou print_r pra exibir propriedades de retorno da saída.
'''

funções Costumers = getUrlCustomers();
funções Order     = getUrlOrder();
funções Products  = getUrlProducts();
'''
Dados que podem ser adicionados.

$title       -- Nome do produto

$producttype --Tipo do produto

$vendor      -- Fornecedor 

$price       --Valor Líquido 

$amount      -- Valor total do produto

$taxes       -- Valor Bruto 

$quantity    -- Quantidade de produto comprado

$email       -- Email do cliente

$firstname   -- Nome do cliente

$lastname    -- Sobre nome do cliente

$phone       -- Telefone do cliente

$company     -- Nome da Empresa

$country     -- País

$address     -- Endereço da compra

$suite       -- numero

$city        -- Cidade

$state       -- Estado

$zipcode     -- Codigo Postal

Dados da shopify

$apiKey       -- API key

$apiPassword  -- API key Password

$nameShop     -- Name API

Para pegar esse dados acesse - [Shopify](https://zicpay-com-br.myshopify.com/admin/apps/private)
