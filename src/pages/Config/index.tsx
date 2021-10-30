
import ConfigCardLink from "../../components/card/ConfigCardLink"
import Breadcrumb from "../../components-layout/Breadcrumb"

const userLinks = [
  { label: 'Perfil', description: 'edição do perfil', url: '/configuracao/perfil' },
]
const financaLinks = [
  { label: 'Carteiras', description: `Gestão de 'Carteiras' do módulo Financa`, url: '/configuracao/financa/carteira' },
  { label: 'Grupos', description: `Gestão de 'Grupos' do módulo Financa`, url: '/configuracao/financa/grupo' },
  { label: 'Categorias', description: `Gestão de 'Categorias' do módulo Financa`, url: '/configuracao/financa/categoria' },
]
// const cofreLinks = [
//   { label: 'Cofre', description: `Gestão de 'Carteira' do módulo Cofre`, url: '/configuracao/cofre/carteira' },
// ]
// const investimentoLinks = [
//   { label: 'Carteiras', description: `Gestão de 'Carteiras' do móduglo Investimento`, url: '/configuracao/investimento/carteira' },
//   { label: 'Corretoras', description: `Gestão de 'Corretoras' do móduglo Investimento`, url: '/configuracao/investimento/corretora' },
//   { label: 'Ativos', description: `Gestão de 'Ativos' do móduglo Investimento`, url: '/configuracao/investimento/ativo' },
//   { label: 'Tipos de Ativo', description: `Gestão de 'Tipos de Ativo' do móduglo Investimento`, url: '/configuracao/investimento/ativo-tipo' },
// ]

export default function Configuracao() {

  return (
    <>
      <Breadcrumb
        items={[
          { label: 'Home', url: '/dashboard' },
          { label: 'Configuração' },
        ]}
      />

      <ConfigCardLink title="Perfil" links={userLinks} />

      <ConfigCardLink title="Finanças" links={financaLinks} />

      {/* <ConfigCardLink title="Cofre" links={cofreLinks} /> */}

      {/* <ConfigCardLink title="Investimento" links={investimentoLinks} /> */}
    </>
  )
}
