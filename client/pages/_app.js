import '../styles/globals.css'
import { Inter } from 'next/font/google'
import { useRouter } from 'next/router'

const inter = Inter({ subsets: ['latin'] })

export default function App({ Component, pageProps }) {
    const router = useRouter()
  return (
    <main className={inter.className}>
      <Component {...pageProps} key={router.asPath} />
    </main>
  )
}
