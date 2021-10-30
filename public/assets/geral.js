const analise = document.getElementById('analise');

if(analise != null) {

  fetch(`${path}/analise/dados`)
  .then( res => res.json())
  .then( res => {
    Object.entries(res).map( (value) => {
      let key = value[0]
      let text = value[1]
      let p = document.createElement('p')
      
      key = key.replace('_',' ').replace('_',' ').toLocaleLowerCase()

      p.innerText = `${key}: ${text}`
      
      analise.append(p)
    })
  })
}