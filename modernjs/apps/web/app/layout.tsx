import "./globals.css";

export const metadata = {
  title: "Bhagyarekha (Next.js)",
  description: "Modern frontend for Bhagyarekha"
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en">
      <body>{children}</body>
    </html>
  );
}

