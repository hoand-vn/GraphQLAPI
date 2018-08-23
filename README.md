# GraphQL API
demonstration using GraphQL as plugins in EC-CUBE 4.0

## Installation

 - GraphQL library: https://github.com/webonyx/graphql-php
 - E-commercial EC-CUBE 4.0 : https://www.ec-cube.net/download/
 - Document for EC-CUBE 4.0 : https://cubevn.github.io/ec-cube/3.n/document/getting/install.html

## Examples
### using : GraphiQL
- Query
```
{
  product(id: 1) {
    id
    name
    Categories {
      id
      name
    }
    ProductClasses {
      id
      code
      ClassCategory1 {
        id
        name
      }
      ClassCategory2 {
        id
        name
      }
    }
  }
}
```
- Mutation
```
mutation {
  product(id: 1, name: "new name") {
    id
    name
  }
}
```