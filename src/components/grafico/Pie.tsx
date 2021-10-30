import { Pie } from 'react-chartjs-2'
import { IGraficoProps } from '../../types/global'

export default function GraficoPie(props: IGraficoProps) {

  let legend = {
    position: 'right',
    display: true
  }

  if (window.innerWidth < 992) {
    legend.position = 'top'
  }

  return (!props.value && !props.label)
    ? null
    : (
      <Pie
        data={{
          labels: props.label,
          datasets: [
            {
              label: false,
              data: props.value,
              backgroundColor: ['#adb5bd', '#dee2e6'],
              borderColor: ['#6c757d'],
              borderWidth: 1,
            }
          ]
        }}
        options={{
          responsive: true,
          animation: false,
          plugins: {
            legend,
            title: {
              display: !!props?.title,
              text: props?.title,
              padding: 0,
              font: {
                size: 18
              }
            }
          },
        }}
      />
    )
}
