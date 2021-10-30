import { Bar } from 'react-chartjs-2'
import { IGraficoProps } from '../../types/global'

export default function GraficoBar(props: IGraficoProps) {

  let height = 175

  if (window.innerWidth >= 1200) height = 100
  if (window.innerWidth < 1200) height = 90
  if (window.innerWidth < 768) height = 80
  if (window.innerWidth < 576) height = 200
  if (window.innerWidth < 400) height = 250

  return (!props.value && !props.label)
    ? null
    : (
      <Bar
        height={height}
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
            legend: {
              display: false
            },
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
