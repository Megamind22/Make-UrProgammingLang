# Scanner nd Parser of Compiler
My own language is a case sensitive objects oriented . A program consists of class declaration which includes variables declaration 
and sequence of Methods declarations. Each method consists in turn of 
variable declarations and statements.
### the Back-End of my Language is PHP

# Review the token in scanner
#### I write basics of lang.. rest of some in code
<table>
<thead>
  <tr>
    <th>source file of the program</th>
    <th colspan="1">Keywords</th>
    <th colspan="1">Meaning</th>
    <th colspan="1">Return Token</th>
  </tr>
</thead>
<tbody>
  <tr>
  </tr>
  <tr>
    <td>lexical Analyzer</td>
    <td>Type</td>
    <td>is the blueprint from which 
individual objects are created.</td>
    <td>Class</td>
  </tr>
  <tr>
    <tr>
    <td></td>
    <td>Infer</td>
    <td>Inheritance in oop.</td>
    <td>Inheritance</td>
  </tr>
  </tr>
  <tr>
    <tr>
    <td></td>
    <td>If—Else</td>
    <td>conditional statements</td>
    <td>Condition</td>
  </tr>
  </tr>
  <tr>
    <tr>
    <td></td>
    <td>Ipok</td>
    <td>Integer type</td>
    <td>Integer</td>
  </tr>
  </tr>
  <tr>
    <tr>
    <td></td>
    <td>Sipok</td>
    <td>Signed Integer type</td>
    <td>SInteger</td>
  </tr>
  </tr>
  <tr>
    <tr>
    <td></td>
    <td>Craf</td>
    <td>Char type</td>
    <td>Character</td>
  </tr>
  </tr>
  <tr>
    <tr>
    <td></td>
    <td>Sequence</td>
    <td>Group of characters</td>
    <td>String</td>
  </tr>
  </tr>
  <tr>
    <tr>
    <td></td>
    <td>However/When </td>
    <td>repeatedly execute code as long as 
condition is true</td>
    <td>Loop</td>
  </tr>
  </tr>
  <tr>
    <tr>
    <td></td>
    <td>Srap </td>
    <td>grouped list of variables placed 
under one name</td>
    <td>Struct</td>
  </tr>
  </tr>
  <tr>
    <tr>
    <td></td>
    <td>Scan –Conditionof </td>
    <td>To switch between many cases</td>
    <td>Switch</td>
  </tr>
  </tr>
  <tr>
</tbody>
</table>


# Parser grammar rules(Semantic Analysis)
          1. Program →Start-Symbols ClassDeclaration End-Symbols.
          2. Start-Symbols →@| ^
          3. End-Symbols→$ |#
          4. ClassDeclaration→ Type ID{ Class_Implementation} | Type ID Infer { 
          Class_Implementation}
          5. Class_Implementation→ Variable_Decl Class_Implementation| 
          Method_Decl Class_Implementation | Comment Class_Implementation | 
          require_command Class_Implementation| Func _Call 
          Class_Implementation |em
          6. Method_Decl→ Func Decl ;| Func Decl { Variable_Decl Statements }
          7. Func Decl →Type ID (ParameterList)
          8. Type → Ipok |Sipok |Craf |Sequence |Ipokf |Sipokf |Valueless |Rational
          9. ParameterList →em| None | Non-Empty List
          10. Non-Empty List→ Type ID | Non-Empty List , Type ID
          11. Variable_Decl→ em | Type ID_List ; Variable_Decl | Type ID_List 
          [ID] ; Variable_Decl
          12. ID_List →ID | ID_List , ID
          13. Statements→em | Statement Statements
          14. Statement→Assignment | If _Statement | However _Statement |
          when_Statement | Respondwith _ Statement | Endthis 
          _Statement|Scanvalur (ID ); | Print (Expression); | 
          15. Assignment→ Variable_Decl = Expression;
          16. Func _Call → ID (Argument_List) ;
          17. Argument_List →em | NonEmpty_Argument_List
          18. NonEmpty_Argument_List →Expression | NonEmpty_Argument_List , 
          Expression
          19. Block Statements→{ statements }
          20. If _Statement→ if (Condition _Expression) Block Statements | if 
          (Condition _Expression) Block Statements else Block Statements
          21. Condition _Expression→ Condition |Condition Condition _Op 
          Condition
          22. Condition _Op → && | || 
          23. Condition→ Expression Comparison _Op Expression 
          24. Comparison _Op → == | != | > | >= | < | <=
          25. However _Statement → However (Condition _Expression) Block 
          Statements
          26. when _Statement → when ( expression ; expression ; expression ) Block 
          Statements
          27. Respondwith _Statement→ Respondwith Expression ; | return ID ;
          28. Endthis _Statement→ Endthis;
          29. Expression → Term |Expression Add_Op Term
          30. Add_Op → + | -
          31. Term→Factor| Term Mul_Op Factor 
          32. Mul_Op→* | /
          33. Factor→ ID| Number
          34. Comment →</ STR /> | ***STR
          35. Require_command →Require(F_name.txt);
          36. F_name →STR

# Output
### input 
    1- @ Type Person{
    2- Rational G() {
    3- int frt=5;
    4- when (in counter<num){
    5- int reg3=reg3-1; } }} $
###  Scanner_Output
    Line : 1 Token Text: @ Token Type: Start Symbol
    Line : 1 Token Text: Type Token Type: Class
    Line : 1 Token Text: Person Token Type: Identifier
    Line : 1 Token Text: { Token Type: Braces
    Line : 2 Token Text: Rational Token Type: Boolean
    Line : 2 Token Text: G Token Type: Identifier
    Line : 2 Token Text: ( Token Type: Braces
###  Parser_Output
    Line : 1 Matched Rule used: Program and ClassDeclaration
    Line : 2 Matched Rule used: Func Decl
    Line : 3 Not Matched 
    Total NO of errors: 1
# Contact
You can communicate through following e-mail to get All Src code with web(UI) nd Navigator:
 -mohameda.shaker16@gmail.com

