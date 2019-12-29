<?php
$tokensAcao = [
  0 => [
    'WHILE' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 1
    ],
    'IF' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 1
    ]
  ],
  1 => [
    'ABRE_PARENTESES' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 2
    ]
  ],
  2 => [
    'VARIAVEL' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 3
    ],
    'CONSTANTE' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 3
    ],
    'TRUE' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 4
    ],
  ],
  10 => [
    'VARIAVEL' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 11
    ],
    'CONSTANTE' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 11
    ]
  ],
  3 => [
    'MAIOR' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 10
    ],
    'MAIOR_IGUAL' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 10
    ],
    'MENOR' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 10
    ],
    'MENOR_IGUAL' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 10
    ],
  ],
  11 => [
    'FECHA_PARENTESES' => [
      'ACAO'   => 'REDUCE',
      'ESTADO' => 8,
      'REMOVE' => 3
    ]
  ],
  4 => [
    'FECHA_PARENTESES' => [
      'ACAO'   => 'REDUCE',
      'ESTADO' => 8,
      'REMOVE' => 1
    ]
  ],
  5 => [
    'ABRE_CHAVES' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 6
    ]
  ],
  6 => [
    'FECHA_CHAVES' => [
      'ACAO'   => 'REDUCE',
      'ESTADO' => 9,
      'REMOVE' => 5
    ]
  ],
  9 => [
    'FECHA_CHAVES' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 7,
    ]
  ],
  7 => [
    'EOF' => [
      'ACAO'   => 'ACCEPT',
      'ESTADO' => 0,
    ]
  ],
  8 => [
    'FECHA_PARENTESES' => [
      'ACAO'   => 'SHIFT',
      'ESTADO' => 5,
    ]
  ],
];

$PILHA = [];

if(isset($_POST['analisar'])) {
  echo sintatico($TOKENS, $tokensAcao);
}

function empilhar($estado) {
  global $PILHA;
  array_push($PILHA, $estado);
}

function desempilhar() {
  global $PILHA;
  array_pop($PILHA);
}

function retornaTopoPilha() {
  global $PILHA;
  
  if(count($PILHA) > 0) {
    return $PILHA[count($PILHA)-1];
  }
}

function sintatico($TOKENS, $tokensAcao) {
  $TOKENS[] = 'EOF'; // Sinaliza fim da sintáxe
  $estado = 0;
  
  empilhar($estado);
  
  for($i = 0; $i < count($TOKENS); $i++) {
    
    try {
      if($TOKENS[$i] == 'ESPACO') {
        continue;
      }
      
      if(empty($tokensAcao[$estado][$TOKENS[$i]])) {
        throw new Exception("Erro sintático: $TOKENS[$i], Estado: $estado");
      }
      $TRANSICAO = $tokensAcao[$estado][$TOKENS[$i]];
      
      switch ($TRANSICAO['ACAO']) {
        case 'SHIFT':
          $estado = $TRANSICAO['ESTADO'];
          empilhar($estado);
          break;
        case 'REDUCE':
          for ($j = 0; $j < $TRANSICAO['REMOVE']; $j++) {
						desempilhar();
          }
          $estado = $TRANSICAO['ESTADO'];
          empilhar($estado);
					if ($i < count($TOKENS)-1) {
						$i--;
          }
          break;
        case 'ACCEPT':
          return 'Linguagem Aceita!';
          break;
        
        default:
					return "Erro sintático: $TOKENS[$i], Estado: $estado";
      }
    } catch (Exception $ex) {
      return $ex->getMessage();
    }
  }
}
