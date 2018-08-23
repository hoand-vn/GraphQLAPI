# GraphQLAPI
demonstration using GraphQL as plugins in EC-CUBE 4.0

## Installation

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