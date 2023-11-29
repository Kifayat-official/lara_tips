import Image from "next/image"
import Link from "next/link"

export const Logo = () => {
    return (
        <Link href="/">
            <div>
                <Image
                    src="/logo.svg"
                    alt="Logo"
                    height={30}
                    width={30}
                />
            </div>
        </Link>
    )
}