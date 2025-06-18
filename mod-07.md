# Classes.

## Constructor Functions.

Funções responsáveis pela criação de objetos. O conceito de uma função construtora de objetos é implementado em outras linguagens como Classes.

```js
function Button(text, background) {
  this.text = button
  this.background = background
}

Button.prototype.element = function() {
  const $buttonElement = document.createElement('button')
  $buttonElement.innerText = this.text
  $buttonElement.style.background = this.background

  return $buttonElement
}

const buttonBlue = new Button('Comprar', 'blue')
```

Neste exemplo temos uma **Constructor Function**, passamos em seus construtor _text_ e _background_ para criação do nosso botão.

Logo após adicionamos dentro do seu _prototype_ um método chamado **element**. Onde criamos um elemento de botão dentro do DOM e passamos as nossas propriedades para esse elemento criado através do _this.propriedade_ e retornamos o nosso botão criado.

Criamos uma instância desse botão passando as propriedades para o mesmo.

## Class.

O ES6 trouxe uma nova sintaxe para implementarmos funções construtoras. Agora podemos utilizar a palavra chave **class**. É considerada _syntactial sugar_, pois por baixo dos panos continua utilizando o sistema de protótipos de uma função construtora para criar a classe.

```js
class Button {
  constructor(text, background) {
    this.text = text
    this.background = background
  }

  element() {
    const $buttonElement = document.createElement('button')
    $buttonElement.innerText = this.text
    $buttonElement.style.background = this.background

    return $buttonElement
  }
}

const blueButton = new Button('Comprar', 'blue')
```

Neste caso acontece tudo da mesma forma como uma **_constructor function_**, porém a forma da escrita se aplica usando um _syntactial sugar_.

## Class VS Constructor Function.

```js
class Button {
  constructor(propriedade) {
    this.propriedade = propriedade
  }
  metodo1() {}
  metodo2() {}
}
function Button(propriedade) {
  this.propriedade = propriedade
}
Button.prototype.metodo1 = function() {}
Button.prototype.metodo1 = function() {}
```

[Para saber mais sobre Class e Constructor Functions](https://davidtang.io/tutorials/javascript-constructor-functions-and-classes)

## Constructor.

O método **constructor(arg) {}** é um método especial de classe. Nele você irá definir todas as propriedades do objeto que será criado. Os argumentos passados no new, vão direto para o constructor.

```js
class Button {
  constructor(text, background, color) {
    this.text = text
    this.background = background
    this.color = color
  }
}
const blueButton = new Button('Clique', 'blue', 'white')
// Button {text: 'Clique', background: 'blue', color: 'white'}
```

## Constructor Return.

Por padrão a classe retorna this. Ou seja, this é o objeto criado com o **new Class**. Podemos modificar isso alterando o return do constructor, o problema é que perderá toda a referência do objeto.

```js
class Button {
  constructor(text) {
    this.text = text
    return this.element() // não fazer
  }
  element() {
    document.createElement('button').innerText = this.text
  }
}
const btn = new Button('Clique')
// <button>Clique</button>
```

## This.

Assim como em uma função construtora, this faz referência ao objeto criado com o new. Você pode acessar as propriedades e métodos da classe utilizando o this.

```js
class Button {
  constructor(text) {
    this.text = text
  }
  element() {
    const buttonElement = document.createElement('button')
    buttonElement.innerText = this.text
    return buttonElement
  }
  appendElementTo(target) {
    const targetElement = document.querySelector(target)
    targetElement.appendChild(this.element())
  }
}
const blueButton = new Button('Clique')
blueButton.appendElementTo('body')
```

## Propriedades.

Podemos passar qualquer valor dentro de uma propriedade.

```js
class Button {
  constructor(options) {
    this.options = options
  }
}
const blueOptions = {
  backgroundColor: 'blue',
  color: 'white',
  text: 'Clique',
  borderRadius: '4px'
}
const blueButton = new Button(blueOptions)
blueButton.options
```

## Static vs Prototype.

Por padrão todos os métodos criados dentro da classe irão para o protótipo da mesma. Porém podemos criar métodos diretamente na classe utilizando a palavra chave **static**. Assim como **_[].map()_** é um método de uma array e **_Array.from()_** é um método do construtor Array.

```js
class Button {
  constructor(text) {
    this.text = text
  }
  static create(background) {
    const elementButton = document.createElement('button')
    elementButton.style.background = background
    elementButton.innerText = 'Clique'
    return elementButton
  }
}
const blueButton = Button.create('blue')
```

## Static.

Você pode utilizar um método **static** para retornar a própria classe com propriedades já pré definidas.

```js
class Button {
  constructor(text, background) {
    this.text = text
    this.background = background
  }

  element() {
    const elementButton = document.createElement('button')
    elementButton.innerText = this.text
    elementButton.style.background = this.background
    return elementButton
  }

  static createBlue(text) {
    return new Button(text, 'blue')
  }
}
const blueButton = Button.createBlue('Comprar')
```

# Get e Set.

Podemos definir comportamentos diferentes de _get_ e _set_ para um método.

```js
const button = {
  get element() {
    return this._element
  }

  set element(type) {
    return this._element = document.createElement(type)
  }
}

button.element = 'button' // set
button.element // get <button></button>
```

## Valores estáticos.

Se definirmos apenas o get de um método, teremos então um valor estático que não será possível mudarmos.

```js
const matematica = {
  get PI() {
    return 3.14
  }
}

matematica.PI // get 3.14
matematica.PI = 20 // set - valor não foi alterado.
```

## Set.

Eu posso ter um método com _set_ apenas, que modifique outras propriedades do meu objeto.

```js
const frutas = {
  lista: [],
  set nova(fruta) {
    this.lista.push(fruta)
  }
}
frutas.nova = 'Banana'
frutas.nova = 'Morango'
frutas.lista // ['Banana', Morango];
```

## Class.

Assim como em um objeto, as classes podem ter métodos de _get_ e _set_ também.

```js
class Button {
  constructor(text, color) {
    this.text = text
    this.color = color
  }

  get element() {
    const $buttonElement = document.createElement('button')
    $buttonElement.innerText = this.text
    $buttonElement.style.color = this.color

    return $buttonElement
  }
}

const blueButton = new Button('Comprar', 'blue')
blueButton.element // retorna o elemento
```

## Set e Class.

Como _set_ podemos modificar apenas parte do elemento de _get_. É comum definirmos variáveis **privadas**, utilizando o _underscore_ **\_privada**, que nada mais é um conversão.

```js
class Button {
  constructor(text) {
    this.text = text
  }

  get element() {
    const elementType = this._elementType || 'button'
    const $buttonElement = document.createElement(elementType)
    $buttonElement.innerText = this.text
    return $buttonElement
  }

  set element(type) {
    this._elementType = type
  }
}
const blueButton = new Button('Comprar')
blueButton.element // retorna o elemento
```

# Extends.

## Subclasses.

É possível criamos uma subclasse, esta irá ter acesso aos métodos da classe à qual ela estendeu através do seu protótipo.

```js
class Veiculo {
  constructor(rodas) {
    this.rodas = rodas
  }

  acelerar() {
    console.log('Acelerou')
  }
}

class Moto extends Veiculo {
  empinar() {
    console.log('Empinou com ' + this.rodas + ' rodas')
  }
}

const honda = new Moto(2)
console.log(honda.empinar())
```

## Métodos.

Podemos escrever por cima de um método herdado.

```js
class Veiculo {
  constructor(rodas) {
    this.rodas = rodas
  }
  acelerar() {
    console.log('Acelerou')
  }
}
class Moto extends Veiculo {
  acelerar() {
    console.log('Acelerou muito')
  }
}
const honda = new Moto(2)
honda.acelerar()
```

## Super.

É possível utilizar a palavra chave **_super_** para falarmos com a classe pai que e acessarmos os seus métodos e propriedades.

```js
class Veiculo {
  constructor(rodas) {
    this.rodas = rodas
  }
  acelerar() {
    console.log('Acelerou')
  }
}
class Moto extends Veiculo {
  acelerar() {
    super.acelerar()
    console.log('Muito')
  }
}
const honda = new Moto(2)
honda.acelerar()
```

## Super e Constructor.

Podemos utilizar o super para estendemos o método constructor.

```js
class Veiculo {
  constructor(rodas, combustivel) {
    this.rodas = rodas
    this.combustivel = combustivel
  }
}
class Moto extends Veiculo {
  constructor(rodas, combustivel, capacete) {
    super(rodas, combustivel)
    this.capacete = capacete
  }
}
const honda = new Moto(4, 'Gasolina', true)
```

## Exercícios.

```js
// Criar um Countdowm que veja quantos dias faltam até o natal.
```

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Countdown</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="container">
      <h1>Countdown</h1>
    </div>
    <span class="countdown" data-js="countdown-element"></span>
    <script type="module" src="main.js"></script>
    <script type="module" src="countdown.js"></script>
  </body>
</html>
```

```js
// main.js

import Countdown from './countdown.js'

const date = new Countdown('24 December 2019 24:59:00 GMT-0300')
const $countdownElement = document.querySelector(
  '[data-js="countdown-element"]'
)

setInterval(() => {
  $countdownElement.innerText = `Faltam: ${date.day} dias ${date.hours} horas ${
    date.minutes
  } minutos e ${date.seconds} segundos para o natal.
`
})
```

```js
// countdown.js

export default class Countdown {
  constructor(futureDate) {
    this.futureDate = futureDate
  }

  get _actualDate() {
    return new Date()
  }

  get _futureDate() {
    return new Date(this.futureDate)
  }

  get _timeStampDiff() {
    return this._futureDate.getTime() - this._actualDate.getTime()
  }

  get day() {
    return Math.floor(this._timeStampDiff / (24 * 60 * 60 * 1000))
  }

  get hours() {
    return Math.floor(this._timeStampDiff / (60 * 60 * 1000))
  }

  get minutes() {
    return Math.floor(this._timeStampDiff / (60 * 1000))
  }

  get seconds() {
    return Math.floor(this._timeStampDiff / 1000)
  }

  get _total() {
    const days = this.day
    const hours = this.hours % 24
    const minutes = this.minutes % 60
    const seconds = this.seconds % 60

    return {
      days,
      hours,
      minutes,
      seconds
    }
  }
}
```
