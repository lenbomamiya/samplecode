
//---------------------------------------------------------------------------------------
// it can read/write BMP file and CBF (Compressed BMP File) !!
// you should include fstream.h and iostream.h before including this header file
// and then declare in main() as
//									CBF test;
//									test.InBMP(*filename);
// programmer:lenbo chen
// update:31DEC,03
//---------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------
class CBF
// declare class CBF
//---------------------------------------------------------------------------------------
{
	private:
		// check the file`s type *.cbf is [C][B][0][1]
		char CBFCheck[4];
		// original BMP`s header occupy 54 bytes
		char check[2];
		int FileSize;
		char reverse[4];
		int DataOffset;
		int HeadSize;
		int width;
		int height;
	    int planes;// 2 bytes
		int ColorBits;// 2 bytes        
		int compression;// 0 express non-compression 
		int ImageSize; 
		int ColorsUsed;// only used in 256 colors mode
		int palette[3];
		// original BMP`s pixel data
		char *PixelPtr;
		// to record how many CBF data are saved
		int CBFDataSize;
		// compressed file`s data, every word contain [R][G][B][offset]
		char *CBFDataPtr;
	
	public:
		void InBMP(char *ptr);
		void OutBMP(char *ptr);
		void InCBF(char *ptr);
		void OutCBF(char *ptr);
		void write(char choice, int value);
		int  read(char choice);
		char *Read_Pixel();
		void Write_Pixel(char *tmp);
		char *Read_CBFData();
		void Write_CBFData(char *tmp);
		void Write_CBFCheck(int choice, char tmp);
};

//---------------------------------------------------------------------------------------
void CBF::InBMP(char *ptr)
// pass in filename`s pointer what BMP`s filename you want to load into memory
//---------------------------------------------------------------------------------------
{
	ifstream ReadBMP;
	ReadBMP.open(ptr, ifstream::binary);
	
	char tmp[4];
	int count, size;

	// read BMP file header
	ReadBMP.get(check[0]);
	ReadBMP.get(check[1]);

	// check file`s type, if it isn`t BMP file type exit(1);
	if((check[0] != 'B') || (check[1] != 'M')){
		cout << "[ERROR] Sorry ! You load a wrong type of file !" << endl;
		cout << "[ CUE ] Please load 24-bits BMP type of file !" << endl;
		exit(1);
	}

	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ReadBMP.get(tmp[2]);
	ReadBMP.get(tmp[3]);
	// turn to decimal
	FileSize = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;
	
	ReadBMP.get(reverse[0]);
	ReadBMP.get(reverse[1]);
	ReadBMP.get(reverse[2]);
	ReadBMP.get(reverse[3]);

	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ReadBMP.get(tmp[2]);
	ReadBMP.get(tmp[3]);
	DataOffset = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;
	
	// read BMP info header
	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ReadBMP.get(tmp[2]);
	ReadBMP.get(tmp[3]);
	HeadSize = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ReadBMP.get(tmp[2]);
	ReadBMP.get(tmp[3]);
	width = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ReadBMP.get(tmp[2]);
	ReadBMP.get(tmp[3]);
	height = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;
	
	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	planes = tmp[0] + tmp[1]*256;
	
	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ColorBits = tmp[0] + tmp[1]*256;
	
	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ReadBMP.get(tmp[2]);
	ReadBMP.get(tmp[3]);
	compression = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;
	
	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ReadBMP.get(tmp[2]);
	ReadBMP.get(tmp[3]);
	ImageSize = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ReadBMP.get(tmp[2]);
	ReadBMP.get(tmp[3]);
	ColorsUsed = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ReadBMP.get(tmp[2]);
	ReadBMP.get(tmp[3]);
	palette[0] = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ReadBMP.get(tmp[2]);
	ReadBMP.get(tmp[3]);
	palette[1] = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadBMP.get(tmp[0]);
	ReadBMP.get(tmp[1]);
	ReadBMP.get(tmp[2]);
	ReadBMP.get(tmp[3]);
	palette[2] = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	// read BMP pixel`s data
	size = width * height * 3;
	PixelPtr = new char[size];
	for(count = 0; count < size; count++){
		ReadBMP.get(tmp[0]);
		PixelPtr[count] = tmp[0];	
	}

	ReadBMP.close();
}

//---------------------------------------------------------------------------------------
void CBF::OutBMP(char *ptr)
// pass in filename`s pointer what BMP`s filename you want to create  
//---------------------------------------------------------------------------------------
{
	ofstream WriteBMP;
	WriteBMP.open(ptr, ofstream::binary);

	char tmp[4];
	int quotient, count, size = width * height * 3;

	// write BMP file header
	WriteBMP << check[0];
	WriteBMP << check[1];

	// turn to 256 to carry
	quotient = FileSize / 256;
	tmp[0] = FileSize % 256;
	FileSize = quotient;
	quotient = FileSize / 256;
	tmp[1] = FileSize % 256;
	FileSize = quotient;
	quotient = FileSize / 256;
	tmp[2] = FileSize % 256;
	FileSize = quotient;
	quotient = FileSize / 256;
	tmp[3] = FileSize % 256;
	WriteBMP << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	WriteBMP << reverse[0] << reverse[1] << reverse[2] << reverse[3];

	quotient = DataOffset / 256;
	tmp[0] = DataOffset % 256;
	DataOffset = quotient;
	quotient = DataOffset / 256;
	tmp[1] = DataOffset % 256;
	DataOffset = quotient;
	quotient = DataOffset / 256;
	tmp[2] = DataOffset % 256;
	DataOffset = quotient;
	quotient = DataOffset / 256;
	tmp[3] = DataOffset % 256;
	WriteBMP << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	// write BMP info header
	quotient = HeadSize / 256;
	tmp[0] = HeadSize % 256;
	HeadSize = quotient;
	quotient = HeadSize / 256;
	tmp[1] = HeadSize % 256;
	HeadSize = quotient;
	quotient = HeadSize / 256;
	tmp[2] = HeadSize % 256;
	HeadSize = quotient;
	quotient = HeadSize / 256;
	tmp[3] = HeadSize % 256;
	WriteBMP << tmp[0] << tmp[1] << tmp[2] << tmp[3];
	
	quotient = width / 256;
	tmp[0] = width % 256;
	width = quotient;
	quotient = width / 256;
	tmp[1] = width % 256;
	width = quotient;
	quotient = width / 256;
	tmp[2] = width % 256;
	width = quotient;
	quotient = width / 256;
	tmp[3] = width % 256;
	WriteBMP << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	quotient = height / 256;
	tmp[0] = height % 256;
	height = quotient;
	quotient = height / 256;
	tmp[1] = height % 256;
	height = quotient;
	quotient = height / 256;
	tmp[2] = height % 256;
	height = quotient;
	quotient = height / 256;
	tmp[3] = height % 256;
	WriteBMP << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	quotient = planes / 256;
	tmp[0] = planes % 256;
	planes = quotient;
	quotient = planes / 256;
	tmp[1] = planes % 256;
	WriteBMP << tmp[0] << tmp[1];

	quotient = ColorBits / 256;
	tmp[0] = ColorBits % 256;
	ColorBits = quotient;
	quotient = ColorBits / 256;
	tmp[1] = ColorBits % 256;
	WriteBMP << tmp[0] << tmp[1];

	quotient = compression / 256;
	tmp[0] = compression % 256;
	compression = quotient;
	quotient = compression / 256;
	tmp[1] = compression % 256;
	compression = quotient;
	quotient = compression / 256;
	tmp[2] = compression % 256;
	compression = quotient;
	quotient = compression / 256;
	tmp[3] = compression % 256;
	WriteBMP << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	quotient = ImageSize / 256;
	tmp[0] = ImageSize % 256;
	ImageSize = quotient;
	quotient = ImageSize / 256;
	tmp[1] = ImageSize % 256;
	ImageSize = quotient;
	quotient = ImageSize / 256;
	tmp[2] = ImageSize % 256;
	ImageSize = quotient;
	quotient = ImageSize / 256;
	tmp[3] = ImageSize % 256;
	WriteBMP << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	quotient = ColorsUsed / 256;
	tmp[0] = ColorsUsed % 256;
	ColorsUsed = quotient;
	quotient = ColorsUsed / 256;
	tmp[1] = ColorsUsed % 256;
	ColorsUsed = quotient;
	quotient = ColorsUsed / 256;
	tmp[2] = ColorsUsed % 256;
	ColorsUsed = quotient;
	quotient = ColorsUsed / 256;
	tmp[3] = ColorsUsed % 256;
	WriteBMP << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	for(count = 0; count < 3; count++){
		quotient = palette[count] / 256;
		tmp[0] = palette[count] % 256;
		palette[count] = quotient;
		quotient = palette[count] / 256;
		tmp[1] = palette[count] % 256;
		palette[count] = quotient;
		quotient = palette[count] / 256;
		tmp[2] = palette[count] % 256;
		palette[count] = quotient;
		quotient = palette[count] / 256;
		tmp[3] = palette[count] % 256;
		WriteBMP << tmp[0] << tmp[1] << tmp[2] << tmp[3];
	}

	// write BMP pixel`s data
	for(count = 0; count < size; count++){
		WriteBMP << PixelPtr[count];
	}
	
	WriteBMP.close();
}

//---------------------------------------------------------------------------------------
void CBF::InCBF(char *ptr)
// pass in filename`s pointer what CBF`s filename you want to load into memory  
//---------------------------------------------------------------------------------------
{
	ifstream ReadCBF;
	ReadCBF.open(ptr, ifstream::binary);
	
	char tmp[4];
	int count, size;

	// read CBF file check code
	ReadCBF.get(CBFCheck[0]);
	ReadCBF.get(CBFCheck[1]);
	ReadCBF.get(CBFCheck[2]);
	ReadCBF.get(CBFCheck[3]);

	// check file`s type, if it isn`t CBF file type exit(1);
	if((CBFCheck[0] != 'C') || (CBFCheck[1] != 'B') || (CBFCheck[2] != '0') || (CBFCheck[3] != '1')){
		cout << "[ERROR] Sorry ! You load a wrong file !" << endl;
		cout << "[ CUE ] Please load version 0.1 CBF type of file !" << endl;
		exit(1);
	}

	// read BMP file header
	ReadCBF.get(check[0]);
	ReadCBF.get(check[1]);

	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ReadCBF.get(tmp[2]);
	ReadCBF.get(tmp[3]);
	// turn to decimal
	FileSize = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;
	
	ReadCBF.get(reverse[0]);
	ReadCBF.get(reverse[1]);
	ReadCBF.get(reverse[2]);
	ReadCBF.get(reverse[3]);

	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ReadCBF.get(tmp[2]);
	ReadCBF.get(tmp[3]);
	DataOffset = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;
	
	// read BMP info header
	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ReadCBF.get(tmp[2]);
	ReadCBF.get(tmp[3]);
	HeadSize = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ReadCBF.get(tmp[2]);
	ReadCBF.get(tmp[3]);
	width = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ReadCBF.get(tmp[2]);
	ReadCBF.get(tmp[3]);
	height = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;
	
	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	planes = tmp[0] + tmp[1]*256;
	
	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ColorBits = tmp[0] + tmp[1]*256;
	
	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ReadCBF.get(tmp[2]);
	ReadCBF.get(tmp[3]);
	compression = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;
	
	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ReadCBF.get(tmp[2]);
	ReadCBF.get(tmp[3]);
	ImageSize = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ReadCBF.get(tmp[2]);
	ReadCBF.get(tmp[3]);
	ColorsUsed = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ReadCBF.get(tmp[2]);
	ReadCBF.get(tmp[3]);
	palette[0] = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ReadCBF.get(tmp[2]);
	ReadCBF.get(tmp[3]);
	palette[1] = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	ReadCBF.get(tmp[0]);
	ReadCBF.get(tmp[1]);
	ReadCBF.get(tmp[2]);
	ReadCBF.get(tmp[3]);
	palette[2] = tmp[0] + tmp[1]*256 + tmp[2]*65536 + tmp[3]*16777216;

	// read CBF compressed data
	size = width * height * 4;
	CBFDataPtr = new char[size];
	for(count = 0; count < size; count++){
		ReadCBF.get(tmp[0]);
		CBFDataPtr[count] = tmp[0];	
	}

	ReadCBF.close();
}

//---------------------------------------------------------------------------------------
void CBF::OutCBF(char *ptr)
// pass in filename`s pointer, what CBF  filename you want to create  
//---------------------------------------------------------------------------------------
{
	ofstream WriteCBF;
	WriteCBF.open(ptr, ofstream::binary);

	char tmp[4];
	int quotient, count;

	// write CBF header
	WriteCBF << CBFCheck[0];
	WriteCBF << CBFCheck[1];
	WriteCBF << CBFCheck[2];
	WriteCBF << CBFCheck[3];

	// write BMP file header
	WriteCBF << check[0];
	WriteCBF << check[1];

	// turn to 256 to carry
	quotient = FileSize / 256;
	tmp[0] = FileSize % 256;
	FileSize = quotient;
	quotient = FileSize / 256;
	tmp[1] = FileSize % 256;
	FileSize = quotient;
	quotient = FileSize / 256;
	tmp[2] = FileSize % 256;
	FileSize = quotient;
	quotient = FileSize / 256;
	tmp[3] = FileSize % 256;
	WriteCBF << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	WriteCBF << reverse[0] << reverse[1] << reverse[2] << reverse[3];

	quotient = DataOffset / 256;
	tmp[0] = DataOffset % 256;
	DataOffset = quotient;
	quotient = DataOffset / 256;
	tmp[1] = DataOffset % 256;
	DataOffset = quotient;
	quotient = DataOffset / 256;
	tmp[2] = DataOffset % 256;
	DataOffset = quotient;
	quotient = DataOffset / 256;
	tmp[3] = DataOffset % 256;
	WriteCBF << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	// write BMP info header
	quotient = HeadSize / 256;
	tmp[0] = HeadSize % 256;
	HeadSize = quotient;
	quotient = HeadSize / 256;
	tmp[1] = HeadSize % 256;
	HeadSize = quotient;
	quotient = HeadSize / 256;
	tmp[2] = HeadSize % 256;
	HeadSize = quotient;
	quotient = HeadSize / 256;
	tmp[3] = HeadSize % 256;
	WriteCBF << tmp[0] << tmp[1] << tmp[2] << tmp[3];
	
	quotient = width / 256;
	tmp[0] = width % 256;
	width = quotient;
	quotient = width / 256;
	tmp[1] = width % 256;
	width = quotient;
	quotient = width / 256;
	tmp[2] = width % 256;
	width = quotient;
	quotient = width / 256;
	tmp[3] = width % 256;
	WriteCBF << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	quotient = height / 256;
	tmp[0] = height % 256;
	height = quotient;
	quotient = height / 256;
	tmp[1] = height % 256;
	height = quotient;
	quotient = height / 256;
	tmp[2] = height % 256;
	height = quotient;
	quotient = height / 256;
	tmp[3] = height % 256;
	WriteCBF << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	quotient = planes / 256;
	tmp[0] = planes % 256;
	planes = quotient;
	quotient = planes / 256;
	tmp[1] = planes % 256;
	WriteCBF << tmp[0] << tmp[1];

	quotient = ColorBits / 256;
	tmp[0] = ColorBits % 256;
	ColorBits = quotient;
	quotient = ColorBits / 256;
	tmp[1] = ColorBits % 256;
	WriteCBF << tmp[0] << tmp[1];

	quotient = compression / 256;
	tmp[0] = compression % 256;
	compression = quotient;
	quotient = compression / 256;
	tmp[1] = compression % 256;
	compression = quotient;
	quotient = compression / 256;
	tmp[2] = compression % 256;
	compression = quotient;
	quotient = compression / 256;
	tmp[3] = compression % 256;
	WriteCBF << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	quotient = ImageSize / 256;
	tmp[0] = ImageSize % 256;
	ImageSize = quotient;
	quotient = ImageSize / 256;
	tmp[1] = ImageSize % 256;
	ImageSize = quotient;
	quotient = ImageSize / 256;
	tmp[2] = ImageSize % 256;
	ImageSize = quotient;
	quotient = ImageSize / 256;
	tmp[3] = ImageSize % 256;
	WriteCBF << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	quotient = ColorsUsed / 256;
	tmp[0] = ColorsUsed % 256;
	ColorsUsed = quotient;
	quotient = ColorsUsed / 256;
	tmp[1] = ColorsUsed % 256;
	ColorsUsed = quotient;
	quotient = ColorsUsed / 256;
	tmp[2] = ColorsUsed % 256;
	ColorsUsed = quotient;
	quotient = ColorsUsed / 256;
	tmp[3] = ColorsUsed % 256;
	WriteCBF << tmp[0] << tmp[1] << tmp[2] << tmp[3];

	for(count = 0; count < 3; count++){
		quotient = palette[count] / 256;
		tmp[0] = palette[count] % 256;
		palette[count] = quotient;
		quotient = palette[count] / 256;
		tmp[1] = palette[count] % 256;
		palette[count] = quotient;
		quotient = palette[count] / 256;
		tmp[2] = palette[count] % 256;
		palette[count] = quotient;
		quotient = palette[count] / 256;
		tmp[3] = palette[count] % 256;
		WriteCBF << tmp[0] << tmp[1] << tmp[2] << tmp[3];
	}

	// write CBF compressed data
	for(count = 0; count < CBFDataSize; count++){
		WriteCBF << CBFDataPtr[count];
	}
	
	WriteCBF.close();
}

//---------------------------------------------------------------------------------------
char *CBF::Read_Pixel()
// pass out BMP pixel`s data array pointer
//---------------------------------------------------------------------------------------
{
	return PixelPtr;
}

//---------------------------------------------------------------------------------------
void CBF::Write_Pixel(char *tmp)
// overwrite BMP pixel`s data array pointer
//---------------------------------------------------------------------------------------
{
	PixelPtr = tmp;
}

//---------------------------------------------------------------------------------------
char *CBF::Read_CBFData()
// pass out CBF data`s array pointer
//---------------------------------------------------------------------------------------
{
	return CBFDataPtr;
}

//---------------------------------------------------------------------------------------
void CBF::Write_CBFData(char *tmp)
// overwrite CBF data`s array pointer
//---------------------------------------------------------------------------------------
{
	CBFDataPtr = tmp;
}

//---------------------------------------------------------------------------------------
void CBF::write(char choice, int value)
// which element you want to change by pass in its 'code name' and integer value
//---------------------------------------------------------------------------------------
{
	switch(choice){
		case 'f':
			FileSize = value;
			break;
		case 'w':
			width = value;
			break;
		case 'h':
			height = value;
			break;
		case 'c':
			CBFDataSize = value;
			break;
		default:
			cout << "[ERROR] Invalid choice !" << endl; 
	}
}

//---------------------------------------------------------------------------------------
int CBF::read(char choice)
// which element you want to read by pass in its 'code name' 
// and then computer will return its integer value
//---------------------------------------------------------------------------------------
{
	switch(choice){
		case 'f':
			return FileSize;
		case 'w':
			return width;
		case 'h':
			return height;
		case 'c':
			return CBFDataSize;
		default:
			cout << "[ERROR] Invalid choice !" << endl;
			return 1;
	}
}

//---------------------------------------------------------------------------------------
void CBF::Write_CBFCheck(int choice, char tmp)
// overwrite CBF checking header by pass in its array number and character
//---------------------------------------------------------------------------------------
{
	CBFCheck[choice] = tmp;
}

//---------------------------------------------------------------------------------------
// end of the file
//---------------------------------------------------------------------------------------
